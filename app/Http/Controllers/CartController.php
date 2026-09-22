<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Models\Product;
use App\Models\ProductWeight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
// use Session;
use Mail;

use function PHPUnit\Framework\isEmpty;

class CartController extends Controller
{
    public function cartList()
    {
        $cartItems = \Cart::getContent();
        // dd($cartItems);

        $session = Session::get('customerid');
        // dd($session);

        return view('frontview.cart', compact('cartItems'));
    }


    public function addToCart(Request $request)
    {
        $attributeId = trim((string) ($request->input('attributeid') ?? ''));
        $sizeLabel = trim((string) ($request->input('product_attribute_size') ?? ''));
        $quantity = (int) ($request->input('quantity', $request->input('quant.1', 1)));
        $quantity = $quantity > 0 ? $quantity : 1;

        if ($attributeId === '' && $sizeLabel === '') {
            session()->flash('error', 'Please select size!');
            return back()->with('error', 'Please select size!');
        }

        try {
            $ledgerQuery = Ledger::orderBy('ledgerId', 'desc')->where([
                'ledger.iStatus' => 1,
                'ledger.isDelete' => 0,
                'ledger.iProductId' => $request->productid,
            ]);

            if ($attributeId !== '') {
                $ledgerQuery->where('ledger.iSize', $attributeId);
            }

            $Ledger = $ledgerQuery
                ->join('product_attributes', 'ledger.iSize', '=', 'product_attributes.id')
                ->first();

            $cartItems = \Cart::getContent();
            $specificId = $attributeId !== '' ? $attributeId : ($Ledger->iSize ?? $sizeLabel);
            $count = $cartItems->filter(function ($item) use ($specificId) {
                return (string) $item->id === (string) $specificId;
            })->sum('quantity');

            $closingBalance = (int) ($Ledger->closingBalance ?? 0);

            if ($request->buttonValue == "addtocart") {
                if (isset($Ledger) && ($closingBalance * 1) > ($count * 1)) {
                    \Cart::add([
                        'id' => $attributeId !== '' ? $attributeId : ($Ledger->iSize ?? $sizeLabel),
                        'productid' => $request->productid,
                        'categoryId' => $request->categoryId,
                        'subcategoryid' => $request->subcategoryid,
                        'productslug' => $request->productslug,
                        'categoryslug' => $request->categoryslug,
                        'categoryname' => $request->categoryname,
                        'name' => $request->productname,
                        'price' => $request->price,
                        'quantity' => $quantity,
                        'size' => $attributeId !== '' ? $attributeId : ($Ledger->iSize ?? $sizeLabel),
                        'size_label' => $sizeLabel !== '' ? $sizeLabel : ($Ledger->product_attribute_size ?? $sizeLabel),
                        'info' => $request->info,
                        'attributes' => [
                            'image' => $request->image,
                        ],
                    ]);

                    $sizeselect = $request->sizeselect ?? "";
                    Session::put('sizeselect', $sizeselect);

                    return redirect()->route('cart.list')
                        ->with('success', 'Product is Added to Cart Successfully !')
                        ->with(compact('sizeselect'));
                }

                $sizeselect = $request->sizeselect ?? "";
                Session::put('sizeselect', $sizeselect);
                session()->flash('error', 'Product is Out Of Stock!');

                return back()->with(compact('sizeselect'));
            }

            if (isset($Ledger) && ($closingBalance * 1) > ($count * 1)) {
                \Cart::add([
                    'id' => $attributeId !== '' ? $attributeId : ($Ledger->iSize ?? $sizeLabel),
                    'productid' => $request->productid,
                    'categoryId' => $request->categoryId,
                    'subcategoryid' => $request->subcategoryid,
                    'productslug' => $request->productslug,
                    'categoryslug' => $request->categoryslug,
                    'categoryname' => $request->categoryname,
                    'name' => $request->productname,
                    'price' => $request->price,
                    'quantity' => 1,
                    'size' => $attributeId !== '' ? $attributeId : ($Ledger->iSize ?? $sizeLabel),
                    'size_label' => $sizeLabel !== '' ? $sizeLabel : ($Ledger->product_attribute_size ?? $sizeLabel),
                    'info' => $request->info,
                    'attributes' => [
                        'image' => $request->image,
                    ],
                ]);
                session()->flash('cartaddsuccess', 'Product is Added to Cart Successfully !');
            } else {
                session()->flash('outofstock', 'Product is Out Of Stock!');
            }

            return redirect()->route('checkout');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }



    public function removeCart(Request $request)
    {
        // dd($request);
        //dd(Session::get('sizeselect'));
        \Cart::remove($request->id);
        session()->flash('success', 'Item Cart Remove Successfully !');

        // return redirect()->route('cart.list');
        return back();
    }

    public function clearAllCart()
    {
        \Cart::clear();

        session()->flash('success', 'All Item Cart Clear Successfully !');

        return back();
        // return redirect()->route('cart.list');
    }


    public function updateCart(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]
        );

        session()->flash('success', 'Item Cart is Updated Successfully !');

        if ($request->expectsJson()) {
            $cartItems = \Cart::getContent();

            return response()->json([
                'quantity' => $cartItems->get($request->id)->quantity,
                'line_total' => $cartItems->get($request->id)->price * $cartItems->get($request->id)->quantity,
                'total' => \Cart::getTotal(),
                'item_count' => $cartItems->count(),
            ]);
        }

        return back();
        // return redirect()->route('cart.list');
    }
}
