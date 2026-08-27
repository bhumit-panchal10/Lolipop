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
        //dd($request);
        if($request->attributeid != "" || $request->product_attribute_size != ""){
            //dd("if");
            try {
                $Ledger = Ledger::orderBy('ledgerId', 'desc')->where([
                    'ledger.iStatus' => 1, 'ledger.isDelete' => 0, 'ledger.iProductId' => $request->productid, 'iSize' => $request->product_attribute_size
                ])
                ->join('product_attributes', 'ledger.iSize', '=', 'product_attributes.id')
                ->first();
                // dd($Ledger);
                $cartItems = \Cart::getContent();
                
                $specificId = $request->attributeid; // Change this to the id you want to count
                $count = $cartItems->filter(function ($item) use ($specificId) {
                    return $item->id === $specificId;
                })->sum('quantity');
                
                $closingBalance = (int)$Ledger->closingBalance;
                
                if ($request->buttonValue == "addtocart") {
                            
                        if (isset($Ledger) &&  ($closingBalance * 1) > ($count * 1)) {
                            
                            \Cart::add([
                                // 'id' => $request->productid,
                                'id' => $request->attributeid,
                                'productid' => $request->productid,
                                'categoryId' => $request->categoryId,
                                'subcategoryid' => $request->subcategoryid,
                                'name' => $request->productname,
                                'price' => $request->price,
                                'quantity' => $request->quant[1],
                                'size' => $request->product_attribute_size,
                                'info' => $request->info,
                                'attributes' => array(
                                    'image' => $request->image,
                                )
                            ]);
                            // session()->flash('success', 'Product is Added to Cart Successfully !');
                            
                            return back()->with('success', 'Product is Added to Cart Successfully !');
                        } else {
                           session()->flash('error', 'Product is Out Of Stock!');
                            // session()->flash('outofstock', 'Product is Out Of Stock!');
                        }
                    
                    return back();
                } else {
                    if (isset($Ledger) &&  ($closingBalance * 1) > ($count * 1)) {
                        \Cart::add([
                            // 'id' => $request->productid,
                            'id' => $request->attributeid,
                            'productid' => $request->productid,
                            'categoryId' => $request->categoryId,
                            'subcategoryid' => $request->subcategoryid,
                            'name' => $request->productname,
                            'price' => $request->price,
                            'quantity' => 1,
                            'size' => $request->product_attribute_size,
                            'info' => $request->info,
                            'attributes' => array(
                                'image' => $request->image,
                            )
                        ]);
                        session()->flash('cartaddsuccess', 'Product is Added to Cart Successfully !');
                    } else {
                        session()->flash('outofstock', 'Product is Out Of Stock!');
                    }
                    return redirect()->route('checkout');
                }
            } catch (\Throwable $th) {
    
                // Rollback & Return Error Message
                return redirect()->back()->with('error', $th->getMessage());
            }   
        } else {
            session()->flash('error', 'Please select size!');
            return back()->with('error', 'Please select size!');
        }
        
    }



    public function removeCart(Request $request)
    {
        // dd($request);
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
        // dd($request);
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

        return back();
        // return redirect()->route('cart.list');
    }
}
