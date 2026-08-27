<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    
   public function index(Request $request)
{
    // Inner: latest ledger rows per product+size with amount = MIN(product_attribute_price)
    $inner = DB::table('ledger as l')
        ->select([
            'l.iProductId',
            'l.iSize',
            'l.closingBalance',
            DB::raw("(SELECT MIN(pa.product_attribute_price) 
                      FROM product_attributes pa 
                      WHERE pa.product_id = l.iProductId) AS amount")
        ])
        ->join('product as p', 'p.productId', '=', 'l.iProductId')
        ->where('p.iStatus', 1)
        ->where('p.isDelete', 0)
        ->whereIn('l.ledgerId', function ($q) {
            $q->selectRaw('MAX(ledgerId)')
              ->from('ledger')
              ->groupBy('iProductId', 'iSize');
        })
        ->where('l.closingBalance', '>', 0)
        ->where('p.productId', '!=', 34); // matches your SQL: exclude productId = 34

    // Wrap the inner query as a derived table "tbl" and aggregate
    $row = DB::table(DB::raw("({$inner->toSql()}) as tbl"))
        ->mergeBindings($inner) // important: carry bindings from $inner
        ->selectRaw("
            SUM(closingBalance) AS qtyCount,
            SUM(closingBalance * COALESCE(CAST(amount AS DECIMAL(16,2)),0)) AS totalAmount
        ")
        ->first();

    // Normalize to the variable names your view expects
    $stock  = (float) ($row->qtyCount ?? 0);
    $amount = (float) ($row->totalAmount ?? 0);

    return view('stock_count.index', compact('stock', 'amount'));
}




    // public function index(Request $request)
    // {
    //     // Subquery: latest ledger row per product
    //     $latestPerProduct = DB::table('ledger')
    //         ->selectRaw('MAX(ledgerId) AS maxId')
    //         ->where('isDelete', 0)
    //         ->where('iStatus', 1)
    //         ->groupBy('iProductId');

    //     // Subquery: aggregated attribute price per product
    //     $attrAgg = DB::table('product_attributes')
    //         ->select('product_id')
    //         ->selectRaw('MAX(NULLIF(product_attribute_price_without_gst,0)) AS price_wo_gst')
    //         ->selectRaw("MAX(CAST(NULLIF(product_attribute_price,'') AS DECIMAL(16,2))) AS price")
    //         ->groupBy('product_id');

    //     // Main query
    //     $row = DB::query()
    //         ->fromSub($latestPerProduct, 'd')
    //         ->join('ledger as l', 'l.ledgerId', '=', 'd.maxId')
    //         ->leftJoin('product as p', function ($join) {
    //             $join->on('p.productId', '=', 'l.iProductId')
    //                 ->where('p.isDelete', 0)
    //                 ->where('p.iStatus', 1);
    //         })
    //         ->leftJoinSub($attrAgg, 'pa_any', function ($join) {
    //             $join->on('pa_any.product_id', '=', 'l.iProductId');
    //         })
    //         ->selectRaw("
    //         SUM(l.closingBalance) AS stock,
    //         SUM(
    //             l.closingBalance *
    //             COALESCE(
    //                 CAST(NULLIF(p.AmountWithOutGST,'') AS DECIMAL(16,2)),
    //                 CAST(NULLIF(p.rate,'') AS DECIMAL(16,2)),
    //                 NULLIF(pa_any.price_wo_gst,0),
    //                 CAST(NULLIF(pa_any.price,'') AS DECIMAL(16,2)),
    //                 0
    //             )
    //         ) AS amount
    //     ")
    //         ->first();

    //     // Convert nulls to 0 for safety
    //     $stock = (float) ($row->stock ?? 0);
    //     $amount = (float) ($row->amount ?? 0);

    //     return view('stock_count.index', compact('stock', 'amount'));
    // }
}
