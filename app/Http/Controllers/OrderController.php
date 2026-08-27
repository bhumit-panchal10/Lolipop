<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shipping;
use App\Models\Customer;
use Barryvdh\DomPDF\Facade\Pdf;
//use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use App\Models\Ledger;
use App\Models\Payment;
use App\Models\State;
use App\Models\ProductAttributes;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function pending(Request $request)
    {

        if (Auth::user()->id == 1) {
            $OrderNo = $request->order_no;
            $FromDate = $request->fromdate;
            $ToDate = $request->todate;
            $Status = $request->strStatus;
            $CustomerName = $request->customer_name;

            $Courier = Courier::orderBy('id', 'desc')->where(['iStatus' => 1, 'isDelete' => 0])->get();

            $Pend = Order::orderBy('order_id', 'desc')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'isDispatched' => 0, 'dispatchCourierId' => 0, 'order.isPayment' => 1])
                ->when($request->customer_name, fn($query, $CustomerName) => $query
                    ->where('order.shipping_cutomerName', 'like', '%' . $CustomerName . '%'))
                ->when($request->order_no, fn($query, $OrderNo) => $query
                    ->Where('order.order_id', '=', $OrderNo))
                ->when($request->fromdate, fn($query, $FromDate) => $query
                    ->where('order.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
                ->when($request->todate, fn($query, $ToDate) => $query
                    ->where('order.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
                ->join('state', 'order.shiiping_state', '=', 'state.stateId');
            if ($request->strStatus != "") {
                //  ->when($request->strStatus, fn ($query, $Status) => $query
                $Pend->where('order.isPayment', '=', $request->strStatus);
            }

            $Pending = $Pend->paginate(15);
            // ->toSql();
            // dd($Pending);

            return view('order.pending', compact('Pending', 'FromDate', 'ToDate', 'Courier', 'Status', 'OrderNo', 'CustomerName'));
        }
    }
    
    public function updateShippingMobile(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:order,order_id',
            'shipping_mobile' => 'required|digits:10'
        ]);

        Order::where('order_id', $request->order_id)->update([
            'shipping_mobile' => $request->shipping_mobile,
            'updated_at' => now()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Shipping mobile updated successfully'
        ]);
    }

    public function userpending(Request $request)
    {
        $Courier = Courier::orderBy('id', 'desc')->where(['iStatus' => 1, 'isDelete' => 0])->get();

        $Pending = Order::orderBy('order_id', 'desc')
            ->where(['iStatus' => 1, 'isDelete' => 0, 'isDispatched' => 0, 'dispatchCourierId' => 2])
            ->join('state', 'order.shiiping_state', '=', 'state.stateId')
            ->paginate(15);

        return view('order.userpending', compact('Pending', 'Courier'));
    }
    
    public function moveToOrder($id)
    {
        try {
            // 1. Update payment table like RazorPaySuccess
            Payment::where('order_id', $id)->update([
                'status' => 'Success',
                'iPaymentType' => 2, // manual
                'Remarks' => 'Moved manually to Order'
            ]);

            // 2. Update order payment status
            Order::where("order_id", $id)->update([
                'isPayment' => 1
            ]);
            
             // MAIN ORDER
            $order  = Order::where("order_id", $id)->first();

            // 3. Get order items
            $cart_Items = OrderDetail::where("orderID", $id)->get();
            $iCounter = 0;

            foreach ($cart_Items as $cartItem) {

                // Last stock row
                $opening = Ledger::select('openingBalance', 'closingBalance', 'cr', 'dr', 'iProductId', 'iOrderId')
                    ->orderBy('ledger.ledgerId', 'DESC')
                    ->where([
                        'ledger.iStatus' => 1,
                        'ledger.isDelete' => 0,
                        'iProductId' => $cartItem->productId,
                        'iSize' => $cartItem->size
                    ])
                    ->first();

                $dr = $cartItem->quantity;
                $openingBalance = $opening->closingBalance ?? 0;
                $closing = ($openingBalance - $dr);

                // Insert ledger
                $Ledger = [
                    'iProductId' => $cartItem->productId,
                    'iSize' => $cartItem->size,
                    'iInwardId' => 0,
                    'iOrderId' => $id,
                    'iOrderDetailId' => $cartItem->orderDetailId,
                    'openingBalance' => $openingBalance,
                    'cr' => 0,
                    'dr' => $dr,
                    'closingBalance' => $closing,
                    'created_at' => date('Y-m-d H:i:s'),
                    'strIP' => request()->ip()
                ];

                DB::table('ledger')->insert($Ledger);

                // Refund check
                if ($closing < 0) {
                    OrderDetail::where("orderDetailId", $cartItem->orderDetailId)
                        ->update(['isRefund' => 1]);
                    $iCounter++;
                }
            }

            // 4. Update order note if refund required
            if ($iCounter > 0) {
                $orderNote = $iCounter . " Product need to Refund.";
                Order::where("order_id", $id)->update(["orderNote" => $orderNote]);
            }
            
            // ==========  EMAIL CODE  ==========

            $StateName = State::where(["stateId" => $order->shiiping_state])->first();
            $stateName = $StateName->stateName ?? '';

            $sendEmail = DB::table('sendemaildetails')->where(['id' => 9])->first();
            $adminSetting = DB::table('setting')->select('email')->first();
            $adminEmail = $adminSetting->email ?? null;

            $root = $_SERVER['DOCUMENT_ROOT'];

            // ORDER DETAIL TABLE
            $OrderDetail = OrderDetail::select(
                'orderdetail.orderDetailId',
                'orderdetail.orderID',
                'orderdetail.productId',
                'orderdetail.quantity',
                'orderdetail.rate',
                'orderdetail.amount',
                'orderdetail.size',
                'product.productname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE productphotos.productid=product.productId LIMIT 1) as photo')
            )
                ->where(['orderdetail.iStatus' => 1, 'orderdetail.isDelete' => 0, 'orderdetail.orderID' => $id])
                ->join('product', 'orderdetail.productId', '=', 'product.productId')
                ->get();

            $rowsHtml = '';
            $i = 1;

            foreach ($OrderDetail as $cartItem) {

                $attr = ProductAttributes::orderBy('id', 'desc')
                    ->where(["product_id" => $cartItem->productId, 'id' => $cartItem->size])
                    ->first();

                $Total = $cartItem->quantity * $cartItem->rate;

                $rowsHtml .= "
                <tr>
                    <td style='text-align:center;'>$i</td>
                    <td style='text-align:center;'>{$cartItem->productname}</td>
                    <td style='text-align:center;'>
                        <img width='48' height='48' src='https://thewardrobefashion.in/Product/{$cartItem->photo}'>
                    </td>
                    <td style='text-align:center;'>{$attr->product_attribute_size}</td>
                    <td style='text-align:center;'>{$cartItem->quantity}</td>
                    <td style='text-align:center;'>{$cartItem->rate}</td>
                    <td style='text-align:center;'>{$Total}</td>
                </tr>";
                $i++;
            }

            // LOAD TEMPLATE
            $templatePath = $root . '/mailers/checkoutmail.html';
            $htmlBody = @file_get_contents($templatePath);

            $address = trim(($order->shiiping_address1 ?? '') . ', ' . ($order->shiiping_address2 ?? ''), ', ');

            // REPLACE VALUES
            $replacements = [
                '#order_no'      => $id,
                '#name'          => $order->shipping_cutomerName,
                '#email'         => $order->shipping_email,
                '#mobile'        => $order->shipping_mobile,
                '#mobile1'       => $order->shipping_mobile1,
                '#address'       => e($address),
                '#state'         => e($stateName),
                '#city'          => e($order->shipping_city),
                '#pincode'       => e($order->shipping_pincode),
                '#amount'        => number_format((float)$order->amount, 2),
                '#netAmount'     => number_format((float)$order->netAmount, 2),
                '#tableProductTr' => $rowsHtml,
            ];

            $htmlBody = strtr($htmlBody, $replacements);

            // SEND EMAIL
            $subject = "Order Detail From The Wardrobe Fashion Order No #{$id}";
            $fromMail = $sendEmail->strFromMail ?? config('mail.from.address');
            $fromName = $sendEmail->strFromName ?? config('mail.from.name');

            try {
                if ($adminEmail) {
                    Mail::html($htmlBody, function ($m) use ($adminEmail, $subject, $fromMail, $fromName) {
                        $m->to($adminEmail)->subject($subject);
                        $m->from($fromMail, $fromName);
                    });
                }

                if (!empty($order->shipping_email)) {
                    Mail::html($htmlBody, function ($m) use ($order, $subject, $fromMail, $fromName) {
                        $m->to($order->shipping_email)->subject($subject);
                        $m->from($fromMail, $fromName);
                    });
                }
            } catch (\Throwable $e) {
                Log::error('Checkout email send failed', ['order_id' => $id, 'err' => $e->getMessage()]);
            }

            
            // WHATSAPP + SMS SENT
        
            $ORDER_ID = $id;
            $Customer = Customer::where("customerid", $order->customerid)->first();
            $mobile = $order->shipping_mobile;

            $textMessage = "Dear Customer, Your order will be dispatched within 3 working Days. Tracking Id will be soon issue to you. Regards, Team The Wardrobe Fashion.";

            $cust = new Customer();
            $cust->sendMessage($mobile, $textMessage, "1707172104144059732");
            // $cust->sendWhatsappMessage($mobile, $textMessage);

            $whatsappmsg = "Dear Customer, Your order will be dispatched within 3 working Days. Tracking Id will be soon issue to you. Regards, Team The Wardrobe Fashion.";

            //$whatsappmsg = "*Dear {$order->shipping_cutomerName}*,\n\nYour Order No : $id.\n\nClick below to view your order:\nhttps://thewardrobefashion.in/Order/$ORDER_ID/{$Customer->guid}\n\nRegards,\nTeam WardrobeFashion.";

             //$cust->WhatsappMessage($mobile, $whatsappmsg);

            // 5. Return same page message
            return redirect()->back()->with('success', 'Order successfully moved to Pending Order Page!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function tirupati(Request $request)
    {
        if (Auth::user()->id  == 1) {
            $Courier = Courier::orderBy('id', 'desc')->where(['iStatus' => 1, 'isDelete' => 0])->get();

            $Pending = Order::orderBy('order_id', 'desc')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'isDispatched' => 0, 'dispatchCourierId' => 1])
                ->join('state', 'order.shiiping_state', '=', 'state.stateId')
                ->paginate(15);

            return view('order.tirupati', compact('Pending', 'Courier'));
        }
    }

    public function delivery(Request $request)
    {
        if (Auth::user()->id  == 1) {
            $Courier = Courier::orderBy('id', 'desc')->where(['iStatus' => 1, 'isDelete' => 0])->get();

            $Pending = Order::orderBy('order_id', 'desc')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'isDispatched' => 0, 'dispatchCourierId' => 2])
                ->join('state', 'order.shiiping_state', '=', 'state.stateId')
                ->paginate(15);

            return view('order.delivery', compact('Pending', 'Courier'));
        }
    }

    public function orderMovedToCourier(Request $request)
    {
        try {
            // //dd('hello');
            // // dd($request);
            // $Data = 0;
            // $data = array('iStatus' => 1, 'isDelete' => 0);
            // foreach ($request->check_list as $id) {
            //     $Data = Order::where('id', '=', $id)->update([
            //         'dispatchCourierId' => $request->strCourier
            //         ]);
            // }
            // echo $Data;

            // Initialize variable to store the count of updated orders
            $updatedOrdersCount = 0;

            // Define data array to update orders
            $data = [
                'dispatchCourierId' => $request->strCourier,
                'iStatus' => 1, // Assuming this is intentional
                'isDelete' => 0 // Assuming this is intentional
            ];

            // Loop through the list of IDs in the request
            foreach ($request->check_list as $id) {
                // Update order with the given ID
                $updatedOrdersCount += Order::where('order_id', $id)->update($data);
            }
            // Output the count of updated orders
            echo $updatedOrdersCount;
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function dispatched(Request $request)
    {
        if (Auth::user()->id  == 1) {
            $FromDate = $request->fromdate;
            $ToDate = $request->todate;
            $OrderNo = $request->order_no;

            $Dispatched = Order::select(
                'order.order_id',
                'order.created_at',
                'order.shipping_cutomerName',
                'order.shipping_email',
                'order.shipping_mobile',
                'order.shipping_city',
                'order.shipping_pincode',
                'order.netAmount',
                'order.isPayment',
                'courier.name',
                'courier.url',
                'state.stateName',
                'order.docketNo',
                'order.isDispatched',
                'order.quikshipx_res_flag',
                'order.quikshipx_order_id',
            )
                ->orderBy('order_id', 'desc')
                ->where(['order.iStatus' => 1, 'order.isDelete' => 0, 'order.isDispatched' => 1])
                ->when($request->order_no, fn($query, $OrderNo) => $query
                    ->Where('order.order_id', '=', $OrderNo))
                ->when($request->fromdate, fn($query, $FromDate) => $query
                    ->where('order.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
                ->when($request->todate, fn($query, $ToDate) => $query
                    ->where('order.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
                ->join('courier', 'order.courier', '=', 'courier.id')
                ->join('state', 'order.shiiping_state', '=', 'state.stateId')
                ->paginate(15);
            //dd($Dispatched);

            return view('order.dispatched', compact('Dispatched', 'FromDate', 'ToDate', 'OrderNo'));
        }
    }

    public function cancel(Request $request)
    {
        if (Auth::user()->id  == 1) {
            $FromDate = $request->fromdate;
            $ToDate = $request->todate;
            $OrderNo = $request->order_no;

            $Cancel = Order::orderBy('order_id', 'desc')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'isDispatched' => 2])
                ->when($request->order_no, fn($query, $OrderNo) => $query
                    ->Where('order.order_id', '=', $OrderNo))
                ->when($request->fromdate, fn($query, $FromDate) => $query
                    ->where('order.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
                ->when($request->todate, fn($query, $ToDate) => $query
                    ->where('order.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
                ->join('state', 'order.shiiping_state', '=', 'state.stateId')
                ->paginate(15);

            return view('order.cancel', compact('Cancel', 'FromDate', 'ToDate', 'OrderNo'));
        }
    }

    public function statustocancel(Request $request, $id)
    {
        try {
            $status = DB::table('order')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'order_id' => $id])
                ->update([
                    'isDispatched' => 2,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            return redirect()->route('order.cancel')->with('success', 'Status Updated Successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function statustodispatched(Request $request)
    {
        // dd($request);
        $session = Auth::user()->id;
        //   try {
        $CheckCourier = Order::where(['iStatus' => 1, 'isDelete' => 0, 'courier' => $request->courier, 'docketNo' => $request->docketNo])->first();
        // dd($CheckCourier);
        if (!($CheckCourier) && $CheckCourier == null) {
            // dd('if');
            $status = DB::table('order')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'order_id' => $request->order_id])
                ->update([
                    'courier' => $request->courier,
                    'docketNo' => $request->docketNo,
                    'isDispatched' => 1,
                    'isDispatchedBy' => $session,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            $Order = Order::where(['iStatus' => 1, 'isDelete' => 0, 'order_id' => $request->order_id])->first();
            $Courier = Courier::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->courier])->first();
            $sendEmail = DB::table('sendemaildetails')->where(['id' => 10])->first();
            $toMail = $Order->shipping_email;
            $subject = $sendEmail->strSubject;

            $urlToClient = "";
            // $urlToClient = $Courier->url . $request->docketNo;
            $DocketType = "Docket No";
            if ($Order->courier == 1) {
                $urlToClient = $Courier->url;
                $DocketType = "AWB No";
            } elseif ($Order->courier == 2){
                $urlToClient = $Courier->url . $request->docketNo;
                $DocketType = "Docket No";
            }elseif ($Order->courier == 4){
                $urlToClient = $Courier->url;
                $DocketType = "Consignment No";
            }
            else
            {
                $urlToClient = $Courier->url;
                $DocketType = "Artical No";
            }

            $root = $_SERVER['DOCUMENT_ROOT'];
            $htmlBody = file_get_contents($root . '/mailers/dispatchemail.html');
            $htmlBody = str_replace(
                ['#orderNo', '#courierName', '#docketNo', '#link','#docketType'],
                [$request->order_id, $Courier->name ?? '', $request->docketNo, $urlToClient,$DocketType],
                $htmlBody
            );

            // 3) Send with Laravel Mail (instead of raw mail())
            try {
                Mail::html($htmlBody, function ($m) use ($toMail, $subject, $sendEmail) {
                    $m->to($toMail)
                        ->subject($subject);

                    // optional: set From from DB (fallback to .env)
                    if (!empty($sendEmail->strFromMail)) {
                        $m->from($sendEmail->strFromMail, $sendEmail->strFromName ?? config('app.name'));
                    }
                    // optional: bcc admin
                    // $m->bcc('orders@thewardrobefashion.in');
                });

                Log::info("Dispatched mail sent to {$toMail}");
            } catch (\Throwable $e) {
                // Don’t block the flow if email fails; show a warning
                Log::error('Dispatched mail failed', ['err' => $e->getMessage()]);
                return redirect()
                    ->route('order.dispatched')
                    ->with('success', 'Status updated, but email could not be sent. (' . $e->getMessage() . ')');
            }

            $Customer = Customer::where(["customerid" => $Order->customerid])->first();
            $InsertedId =  $Customer->customerid;
            $ORDER_ID = $Order->order_id;
            $MobileNumber = $Order->shipping_mobile;
            $Setting = Setting::where(["id" => 1])->first();
            $key = $Setting->api_key;
            $shippingName  = $Order->shipping_cutomerName;

            if ($Order->courier == 1) {
                $whatsappmsg = "*Dear $shippingName*,\n\nYour parcel has been dispatch.\n\nTo track your order, Visit below link.\n\nLink : $urlToClient\n\nYour Awb No : $request->docketNo\n\nRegards,\nTeam The Wardrobe Fashion.";
            }
            if ($request->courier == 4) {
                $whatsappmsg = "*Dear $shippingName*,\n\nYour parcel has been dispatch.\n\nTo track your order, Visit below link.\n\nLink : $urlToClient\n\nYour consignment No : $request->docketNo\n\nRegards,\nTeam The Wardrobe Fashion.";
            }
            else {
                $whatsappmsg = "*Dear $shippingName*,\n\nClick on the below link to track your order:\n$urlToClient\n\nRegards,\nTeam The Wardrobe Fashion.";
            }

            $message = "Dear $Order->shipping_cutomerName, Click on the link below to track your order: $urlToClient Regards , Team The Wardrobe Fashion";

            $customer = new Customer();
            $status = $customer->sendWhatsappMessage($MobileNumber, $key, $message, $InsertedId);

            $customer = new Customer();

            $docketNo = $request->docketNo;

            if ($request->courier == 1) {
                $status = $customer->tirupatiMsg($MobileNumber, $docketNo);
            } elseif ($request->courier == 2){
                $status = $customer->delhiveryMsg($MobileNumber, $docketNo);
            }
            elseif ($request->courier == 4){
                $status = $customer->ShreemahavirMsg($MobileNumber, $docketNo);
            }
            else
            {
                $status = $customer->indianpostMsg($MobileNumber, $docketNo);
            }
            $mobile = $MobileNumber;
            //Whatsapp
            // $whatsapp = $customer->WhatsappMessage($mobile, $whatsappmsg);

            return redirect()->route('order.dispatched')->with('success', 'Status Updated Successfully.');
        } else {
            // dd('else');
            return back()->with('error', 'Docket No Already Exists.');
        }
        //   } catch (\Throwable $th) {
        //         // Rollback & Return Error Message
        //         return redirect()->back()->with('error', $th->getMessage());
        //     } 
    }


    public function statustopending(Request $request, $id)
    {
        try {
            $status = DB::table('order')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'order_id' => $id])
                ->update([
                    'isDispatched' => 0,
                    'dispatchCourierId' => 0,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            return redirect()->route('order.pending')->with('success', 'Status Updated Successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function orderdetail(Request $request, $id)
    {

        $Shipping = Shipping::select('rate as shippingcharge')->orderBy('id', 'desc')->first();
        $data = Order::select('order.*', 'state.stateName')->orderBy('order_id', 'DESC')->where(['iStatus' => 1, 'isDelete' => 0, 'order_id' => $id])
            ->join('state', 'state.stateId', '=', 'order.shiiping_state')->first();
        // dd($data);
        $detail = OrderDetail::select(
            'order.cutomerName',
            'order.mobile',
            'order.email',
            'order.address',
            'order.state',
            'order.city',
            'order.shipping_cutomerName',
            'order.shipping_mobile',
            'order.shipping_email',
            'order.shiiping_address1',
            'order.shiiping_address2',
            'order.shiiping_state',
            'order.shipping_city',
            'order.shipping_pincode',
            'order.amount as totalamount',
            'order.pincode',
            'orderdetail.quantity',
            'orderdetail.rate',
            'orderdetail.amount',
            'orderdetail.size',
            'product.productname',
            'orderdetail.isRefund',
            DB::raw('(SELECT product_attribute_size FROM product_attributes WHERE product_attributes.id=orderdetail.size) as product_attribute_size'),
            DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
        )
            ->orderBy('orderDetailId', 'DESC')
            ->where(['orderdetail.iStatus' => 1, 'orderdetail.isDelete' => 0, 'orderdetail.orderID' => $data->order_id])
            ->join('order', 'orderdetail.orderID', '=', 'order.order_id')
            ->join('product', 'orderdetail.productId', '=', 'product.productId')
            ->get();
        // dd($detail);

        return  view('order.productdetail', compact('data', 'detail', 'id', 'Shipping'));
    }

    public function DetailPDF(Request $request, $id)
    {
        // dd($id);
        if (Auth::user()->id  == 1) {

            $Shipping = Shipping::select('rate as shippingcharge')->orderBy('id', 'desc')->first();

            $data = Order::select(
                'order.*',
                'state.stateName',
                'courier.id',
                'courier.name as couriername',
            )
                ->orderBy('order_id', 'DESC')
                ->where(['order.iStatus' => 1, 'order.isDelete' => 0, 'order.order_id' => $id])
                ->join('state', 'state.stateId', '=', 'order.shiiping_state')
                ->leftjoin('courier', 'order.courier', '=', 'courier.id')
                ->first();

            $detail = OrderDetail::select(
                'order.order_id',
                'order.cutomerName',
                'order.shipping_cutomerName',
                'order.mobile',
                'order.shipping_mobile',
                'order.email',
                'order.shipping_email',
                'order.address',
                'order.shiiping_address1',
                'order.shiiping_address2',
                'order.state',
                'order.shiiping_state',
                'order.city',
                'order.shipping_city',
                'order.pincode',
                'order.shipping_pincode',
                'order.docketNo',
                'order.discount',
                'order.netAmount',
                'order.amount as totalamount',
                'orderdetail.orderID',
                'orderdetail.quantity',
                'orderdetail.rate',
                'orderdetail.amount',
                'orderdetail.size',
                'product.productname',
                'courier.id',
                'courier.name as couriername',
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId ORDER BY product.productId  LIMIT 1) as photo'),
                DB::raw('(SELECT product_attribute_size FROM product_attributes WHERE product_attributes.id=orderdetail.size) as product_attribute_size')
            )
                ->orderBy('orderDetailId', 'DESC')
                ->where(['orderdetail.iStatus' => 1, 'orderdetail.isDelete' => 0, 'orderdetail.orderID' => $data->order_id])
                ->join('order', 'orderdetail.orderID', '=', 'order.order_id')
                ->join('product', 'orderdetail.productId', '=', 'product.productId')
                ->leftjoin('courier', 'order.courier', '=', 'courier.id')
                ->get();


            $pdf = PDF::loadView('order.invoice', ['data' => $data, 'detail' => $detail, 'Shipping' => $Shipping]);

            return $pdf->stream('Report.pdf');

            Route::get(
                "/admin/order/pdf/ .'$id'.",
                function () {
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadHTML('<h1>Test</h1>');
                    return $pdf->download('invoice.pdf');
                }
            );
        }
    }

    public function DispatchPDF(Request $request, $id)
    {
        if (Auth::user()->id  == 1) {

            $data = Order::orderBy('order_id', 'desc')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'order_id' => $id])
                ->join('state', 'order.shiiping_state', '=', 'state.stateId')
                ->first();
            // dd($data); 

            $pdf = PDF::loadView('order.DispatchPDF', ['data' => $data]);
            return $pdf->stream('Dispatch.pdf');

            Route::get(
                "/admin/dispatch/pdf/ .'$id'.",
                function () {
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadHTML('<h1>Test</h1>');
                    return $pdf->download('Dispatch.pdf');
                }
            );
        }
    }
    
    public function generatedelivery(Request $request, $id)
    {
        if (Auth::user()->id  == 1) {

            $data = OrderDetail::select(
                'order.*',
                'category.categoryname',
                'orderdetail.*',
                'product.productname',
                DB::raw('(SELECT strphoto FROM productphotos WHERE productphotos.productid=product.productId LIMIT 1) as photo')
            )
                ->where([
                    'orderdetail.iStatus' => 1,
                    'orderdetail.isDelete' => 0,
                    'orderdetail.orderID' => $id
                ])
                ->join('product', 'orderdetail.productId', '=', 'product.productId')
                ->join('order', 'orderdetail.orderID', '=', 'order.order_id')
                ->join('category', 'orderdetail.categoryId', '=', 'category.categoryId')
                ->get();
            if ($data->isEmpty()) {
                return redirect()->back()->with('error', 'Order data not found');
            }
            $order = $data->first(); // common order info
            $totalAmount = $data->sum('amount');
            $productAmount = ($totalAmount > 2000) ? 2000 : $totalAmount;
            $requestData = [
                "customer_details" => [
                    "customer_full_name" => $order->shipping_cutomerName ?? 'Customer',
                    //"customer_phone_number" => $order->shipping_mobile ?? '',
                    "customer_phone_number" => substr(preg_replace('/[^0-9]/', '', $order->shipping_mobile ?? ''), -10),
                    "customer_full_address" => $order->shiiping_address1 ?? '',
                    "customer_pincode" => $order->shipping_pincode ?? '',
                    "customer_order_id" => $order->order_id,
                    "customer_order_date" => $order->created_at->format('d F Y'),
                    "customer_address_type" => "1",
                    "customer_email_id" => $order->shipping_email ?? '',
                    "customer_alternate_phone_number" => "",
                    "customer_landmark" => $order->shiiping_address2 ?? '',
                ],
                "shipment_details" => [
                    "shipment_package_type" => "1",
                    "shipment_dead_weight_in_grams" => "200",
                    "shipment_length" => "10",
                    "shipment_width" => "20",
                    "shipment_height" => "30",
                    "shipment_pickup_warehouse_id" => "18",
                    "shipment_shipping_mode" => "1",
                    "shipment_pay_mode" => "2",
                    "order_amount" => $productAmount,
                    "cod_amount" => "0",
                    "commodity_amount" => $productAmount,
                    "shipping_amount" => "0",
                    "discount_amount" => "0"
                ],
                "product_details" => []
            ];
           

            // multiple products handle
            $requestData['product_details'] = [
                [
                    "product_name" => "Cloth",
                    "product_category" => "Clothing",
                    "product_sku_code" => "SKU001",
                    "product_tax_rate" => "0",
                    "product_hsn_code" => "hsn",
                    "product_amount" => $productAmount,
                    "product_discount" => "0",
                    "product_quantity" => "1"
                ]
            ];

            // auth inside shipper_details
            $requestData['shipper_details'] = [
                "client_code" => "TWF018",
                "user_id" => "20",
                "user_secret" => "824d5985741db7addba2c1be93b644d058c5abcd1fcdae01552bbc8943519dbb"
            ];
            $response = Http::post('https://head.quikshipx.com/api/create-order-v1', $requestData);
            $responseBody = $response->json();
            $orderMain = Order::where('order_id', $id)->first();
            $orderMain->quikshipx_req = json_encode($requestData);
            $orderMain->quikshipx_res = json_encode($responseBody);
            
            $errorMessage = '';

            if (isset($responseBody['response'][0]['errors'])) {
                $errorMessage = implode(', ', $responseBody['response'][0]['errors']);
            }

            // success check
            if (isset($responseBody['response'][0]['status']) && $responseBody['response'][0]['status'] == 'success') {

                $orderMain->quikshipx_res_flag = 1;
                $orderMain->quikshipx_order_id = $responseBody['response'][0]['order_id'];
                $orderMain->save();

            } else {
                $orderMain->quikshipx_res_flag = 0;
                //$orderMain->save();

                 return redirect()->back()
                ->with('error', $errorMessage ?: 'Something went wrong!');
            }

            $orderMain->save();
            return redirect()->route('order.pending')->with('success', 'Delhivery Generate Successfully.');
            
        }
    }

    public function pendingOrder(Request $request)
    {
        // dd($request);

        if (Auth::user()->id  == 1) {
            $FromDate = $request->fromdate;
            $ToDate = $request->todate;
            $Mobile = $request->mobile;
            $Name = $request->strName;
            $OrderNo = $request->order_no;

            $Courier = Courier::orderBy('id', 'desc')->where(['iStatus' => 1, 'isDelete' => 0])->get();

            $Pend = Order::orderBy('order_id', 'desc')
                ->where(['iStatus' => 1, 'isDelete' => 0, 'isDispatched' => 0, 'dispatchCourierId' => 0, 'order.isPayment' => 0])
                ->when($request->order_no, fn($query, $OrderNo) => $query
                    ->Where('order.order_id', '=', $OrderNo))
                ->when($request->fromdate, fn($query, $FromDate) => $query
                    ->where('order.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
                ->when($request->todate, fn($query, $ToDate) => $query
                    ->where('order.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
                ->when($request->mobile, fn($query, $Mobile) => $query
                    ->where('order.shipping_mobile', 'like', '%' . $Mobile . '%'))
                ->when($request->strName, fn($query, $Name) => $query
                    ->where('order.shipping_cutomerName', 'like', '%' . $Name . '%'))
                ->join('state', 'order.shiiping_state', '=', 'state.stateId');

            $Pending = $Pend->paginate(15);


            return view('order.paymentPendingOrder', compact('Pending', 'FromDate', 'ToDate', 'Courier', 'Name', 'Mobile', 'OrderNo'));
        }
    }

    public function linkSendToCustomer(Request $request, $id)
    {
        //  dd($request);

        try {
            $Order = Order::where(['iStatus' => 1, 'isDelete' => 0, 'order_id' => $id])->first();
            $Courier = Courier::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $Order->courier])->first();

            $Customer = Customer::where(["customerid" => $Order->customerid])->first();
            $InsertedId =  $Customer->customerid;
            $ORDER_ID = $Order->order_id;
            $MobileNumber = $Order->shipping_mobile;
            
            $Setting = Setting::where(["id" => 1])->first();
            $key = $Setting->api_key;
            $shippingName  = $Order->shipping_cutomerName;
            
            // $urlToClient = $Courier->url . $Order->docketNo;
            
            if ($Order->courier == 1) {
                $urlToClient = $Courier->url;
            } else {
                $urlToClient = $Courier->url . $Order->docketNo;
            }
            
            // dd($urlToClient);
        //     $whatsappmsg = "*Dear Customer*,
                    
        // Click on the below link to track your order:
        // $urlToClient
        
        // Regards,     
        // Team The Wardrobe Fashion.";
        
            if ($Order->courier == 1) {
                $whatsappmsg = "*Dear $shippingName*,\n\nYour parcel has been dispatch.\n\nTo track your order, Visit below link.\n\nLink : $urlToClient\n\nYour Awb No : $request->docketNo\n\nRegards,\nTeam The Wardrobe Fashion.";
            } else {
                $whatsappmsg = "*Dear $shippingName*,\n\nClick on the below link to track your order:\n$urlToClient\n\nRegards,\nTeam The Wardrobe Fashion.";
            }


            // $message = "Dear Customer, Click on the link below to track your order: $urlToClient Regards , Team The Wardrobe Fashion";
            $docketNo = $Order->docketNo;

            $customer = new Customer();
            // $status = $customer->sendWhatsappMessage($MobileNumber, $key, $msg, $InsertedId);

            if ($Order->docketNo == 1) {
                $status = $customer->tirupatiMsg($MobileNumber, $docketNo);
            } else {
                $status = $customer->delhiveryMsg($MobileNumber, $docketNo);
            }
            $mobile = $MobileNumber;
            //Whatsapp
            $whatsapp = $customer->WhatsappMessage($mobile, $whatsappmsg);

            return redirect()->route('order.dispatched')->with('success', 'Link Send Successfully.');
        } catch (\Throwable $th) {
            // Rollback & Return Error Message
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function dispatchThroughPaymentPendingOrder(Request $request)
    {
        // dd($request);
        try {
            $CheckCourier = Order::where(['iStatus' => 1, 'isDelete' => 0, 'courier' => $request->courier, 'docketNo' => $request->docketNo])->first();
            // dd($CheckCourier);
            if (!($CheckCourier) && $CheckCourier == null) {
                // dd('if');
                $status = DB::table('order')
                    ->where(['iStatus' => 1, 'isDelete' => 0, 'order_id' => $request->order_id])
                    ->update([
                        'courier' => $request->courier,
                        'docketNo' => $request->docketNo,
                        'isDispatched' => 1,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

                $updateData = array(
                    'isPayment' => 1
                );
                Order::where("order_id", $request->order_id)->update($updateData);

                $cart_Items = OrderDetail::where("orderID", $request->order_id)->get();

                $iCounter = 0;
                foreach ($cart_Items as $cartItem) {

                    $opening = Ledger::select('openingBalance', 'closingBalance', 'cr', 'dr', 'iProductId', 'iOrderId')
                        ->orderBy('ledger.ledgerId', 'DESC')
                        ->where([
                            'ledger.iStatus' => 1,
                            'ledger.isDelete' => 0,
                            'iProductId' => $cartItem->productId,
                            'iSize' => $cartItem->size
                        ])
                        ->first();


                    $dr = $cartItem->quantity;
                    $openingBalance = $opening->closingBalance ?? 0;
                    $closing = ($openingBalance - $dr);

                    $Ledger = array(
                        'iProductId' => $cartItem->productId,
                        'iSize' => $cartItem->size,
                        'iInwardId' =>  0,
                        'iOrderId' => $request->order_id,
                        'iOrderDetailId' =>  $cartItem->orderDetailId,
                        'openingBalance' => $openingBalance,
                        'cr' => 0,
                        'dr' =>  $dr,
                        'closingBalance' =>  $closing,
                        'created_at' => date('Y-m-d H:i:s'),
                        'strIP' => $request->ip()
                    );
                    // dd($Ledger);
                    DB::table('ledger')->insert($Ledger);

                    if ($closing < 0) {
                        OrderDetail::where("orderDetailId", '=', $cartItem->orderDetailId)->update(['isRefund' => 1]);
                        $iCounter++;
                    }
                }
                if ($iCounter > 0) {
                    $orderNote = $iCounter . " Product need to Refund.";
                    Order::where("order_id", $request->order_id)->update(["orderNote" => $orderNote]);
                }


                $Order = Order::where(['iStatus' => 1, 'isDelete' => 0, 'order_id' => $request->order_id])->first();
                $Courier = Courier::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $request->courier])->first();

                $SendEmailDetails = DB::table('sendemaildetails')->where(['id' => 10])->first();
                $toMail = $Order->shipping_email;
                $subject = $SendEmailDetails->strSubject;

                $urlToClient = "";
                $urlToClient = $Courier->url . $request->docketNo;

                $root = $_SERVER['DOCUMENT_ROOT'];
                $htmlBody = file_get_contents($root . '/mailers/dispatchemail.html');
                $htmlBody = str_replace(
                    ['#orderNo', '#courierName', '#docketNo', '#link'],
                    [$request->order_id, $courier->name ?? '', $request->docketNo, $urlToClient],
                    $htmlBody
                );

                // 3) Send with Laravel Mail (instead of raw mail())
                try {
                    Mail::html($htmlBody, function ($m) use ($toMail, $subject, $sendEmail) {
                        $m->to($toMail)
                            ->subject($subject);

                        // optional: set From from DB (fallback to .env)
                        if (!empty($sendEmail->strFromMail)) {
                            $m->from($sendEmail->strFromMail, $sendEmail->strFromName ?? config('app.name'));
                        }
                        // optional: bcc admin
                        // $m->bcc('orders@thewardrobefashion.in');
                    });

                    Log::info("Dispatched mail sent to {$toMail}");
                } catch (\Throwable $e) {
                    // Don’t block the flow if email fails; show a warning
                    Log::error('Dispatched mail failed', ['err' => $e->getMessage()]);
                    return redirect()
                        ->route('order.dispatched')
                        ->with('success', 'Status updated, but email could not be sent. (' . $e->getMessage() . ')');
                }

                // $root = $_SERVER['DOCUMENT_ROOT'];
                // $file = file_get_contents($root . '/mailers/dispatchemail.html', 'r');
                // $file = str_replace('#orderNo', $request->order_id, $file);
                // $file = str_replace('#courierName', $Courier->name, $file);
                // $file = str_replace('#docketNo', $request->docketNo, $file);
                // $file = str_replace('#link', $urlToClient, $file);


                // $to = $toMail;
                // $message = $file;
                // $header = "From:" . $SendEmailDetails->strFromMail . "\r\n";
                // $header .= "MIME-Version: 1.0\r\n";
                // $header .= "Content-type: text/html\r\n";

                // $retval = mail($to, $subject, $message, $header);

                $Customer = Customer::where(["customerid" => $Order->customerid])->first();
                $InsertedId =  $Customer->customerid;
                $ORDER_ID = $Order->order_id;
                $MobileNumber = $Order->shipping_mobile;
                $Setting = Setting::where(["id" => 1])->first();
                $key = $Setting->api_key;
                //         $msg = "*Dear Customer*,

                // Click on the below link to track your order:
                // $urlToClient

                // Regards,
                // Team Wardrobefashion.";

                // $message = "Dear Customer, Click on the link below to track your order: $urlToClient Regards , Team The Wardrobe Fashion";

                $customer = new Customer();
                // $status = $customer->sendWhatsappMessage($MobileNumber, $key, $msg, $InsertedId);

                $docketNo = $request->docketNo;

                if ($request->courier == 1) {
                    $status = $customer->tirupatiMsg($MobileNumber, $docketNo);
                } else {
                    $status = $customer->delhiveryMsg($MobileNumber, $docketNo);
                }

                return redirect()->route('order.dispatched')->with('success', 'Status Updated Successfully.');
            } else {
                // dd('else');
                return back()->with('error', 'Docket No Already Exists.');
            }
        } catch (\Throwable $th) {
            // Rollback & Return Error Message
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
