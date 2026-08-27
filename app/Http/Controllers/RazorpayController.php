<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Razorpay\Api\Api;
use Redirect, Response;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\State;
use App\Models\Ledger;
use App\Models\Customer;
use App\Models\ProductAttributes;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;

class RazorpayController extends Controller
{
    public function index($id)
    {

        $Order = Order::where("order_id", $id)->where(['iStatus' => 1, 'isDelete' => 0])->first();
        // dd($Order);
        $price = $Order->netAmount;

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $OrderAmount = $price * 100;
        $orderData = [
            'receipt'         => $id . '-' . date('dmYHis'),
            'amount'          => $OrderAmount,
            'currency'        => 'INR',
        ];
        $razorpayOrder = $api->order->create($orderData);
        $orderId = $razorpayOrder['id'];
        $data = array(
            'order_id' => $orderId,
            'oid' => $id,
            'amount' => $price,
            'currency' => 'INR',
            'receipt' => $razorpayOrder['receipt'],
        );
        Payment::insert($data);
        // dd($Order); frontview.dataFrom
        return view('razorpay', compact('Order', 'orderId'));
    }
    
    public function razorPaySuccess(Request $request)
    {
        $orderId = $request->orderId;
        $data = [

            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature,
            'razorpay_order_id' => $request->razorpay_order_id,

        ];
        Payment::where('order_id', $orderId)->update($data);

        $stringdata = $orderId . '|' . $request->razorpay_payment_id;
        $generated_signature = hash_hmac('sha256', $stringdata, env('RAZORPAY_SECRET'));
        $razorpay_signature = $request->razorpay_signature;
        if ($generated_signature == $razorpay_signature) {
            $updateData = Payment::where('order_id', $orderId)->update([
                'status' => 'Success',
                'iPaymentType' => 1,
                "Remarks" => "Online Payment"
            ]);
            if ($updateData) {
                $updateProfileData = array(
                    'isPayment' => 1
                );
                Order::where("order_id", $request->orderid)->update($updateProfileData);
            }

            $cart_Items = OrderDetail::where("orderID", $request->orderid)->get();
            $iCounter = 0;
            foreach ($cart_Items as $cartItem) {
               
                 $opening = Ledger::select('openingBalance', 'closingBalance', 'cr', 'dr', 'iProductId', 'iOrderId')
                    ->orderBy('ledger.ledgerId', 'DESC')
                    ->where([
                        'ledger.iStatus' => 1, 'ledger.isDelete' => 0,
                        'iProductId' => $cartItem->productId,
                        'iSize' => $cartItem->size
                    ])
                    ->first();
                    
                    
                    $dr = $cartItem->quantity ;
                    $openingBalance = $opening->closingBalance ?? 0;
                    $closing = ($openingBalance - $dr);
                
                 $Ledger = array(
                    'iProductId' => $cartItem->productId ,
                    'iSize' => $cartItem->size,
                    'iInwardId' =>  0,
                    'iOrderId' => $request->orderid,
                    'iOrderDetailId' =>  $cartItem->orderDetailId,
                    'openingBalance' =>$openingBalance,
                    'cr' => 0,
                    'dr' =>  $dr,
                    'closingBalance' =>  $closing,
                    'created_at' => date('Y-m-d H:i:s'),
                    'strIP' => $request->ip()
                );
                // dd($Ledger);
                DB::table('ledger')->insert($Ledger);
                
                if($closing < 0){
                    OrderDetail::where("orderDetailId",'=',$cartItem->orderDetailId)->update(['isRefund' => 1]);
                    $iCounter++;
                }
            }
            if($iCounter > 0){
                $orderNote = $iCounter." Product need to Refund.";
                Order::where("order_id", $request->orderid)->update(["orderNote" => $orderNote]);
            }
            $ORDER_ID = $request->orderid;
            

            \Cart::clear();
            return $ORDER_ID;
            // $arr = array('msg' => 'Payment successfully credited', 'status' => true);
            // return Response()->json($arr);
        } else {
            $updateData = Payment::where('order_id', $orderId)->update(['status' => 'Fail']);
            
          
            \Cart::clear();
            return 0;
            // $arr = array('msg' => 'Payment Faild', 'status' => false);
            // return Response()->json($arr);
        }
        //b7453e2d214e295aa9f94ebe04ef9652ccc744a365ad94c5eeb758281a2266df

    }

    public function RazorThankYou(Request $request, $id)
    {
        // return view('thankyouPage');
         $order  = Order::where("order_id", $id)->first();
         
            $StateName = State::where(["stateId"=>$order->shiiping_state])->first();
            $stateName = $StateName->stateName ?? '';

            $sendEmail = DB::table('sendemaildetails')->where(['id' => 9])->first();
            $adminSetting = DB::table('setting')->select('email')->first();
            $adminEmail = $adminSetting->email ?? null;

             $root = $_SERVER['DOCUMENT_ROOT'];
            // <!-- $file = file_get_contents($root . '/mailers/checkoutmail.html', 'r');

            // $address = $Order['shiiping_address1'] . ',' . $Order['shiiping_address2'];
            // $file = str_replace('#name', $Order['shipping_cutomerName'], $file);
            // $file = str_replace('#email', $Order['shipping_email'], $file);
            // $file = str_replace('#mobile', $Order['shipping_mobile'], $file);
            // $file = str_replace('#mobile1', $Order['shipping_mobile1'], $file);
            // $file = str_replace('#address', $address, $file);
            // $file = str_replace('#state', $StateName->stateName, $file);
            // $file = str_replace('#city', $Order['shipping_city'], $file);
            // $file = str_replace('#pincode', $Order['shipping_pincode'], $file);
            // $file = str_replace('#amount', $Order['amount'], $file);
            // $file = str_replace('#netAmount', $Order['netAmount'], $file); -->

            // <!-- $html = "";
            // $i = 1;
            // $iTotal = 0; -->
           
            $OrderDetail = OrderDetail::select(
                'orderdetail.orderDetailId',
                'orderdetail.orderID',
                'orderdetail.productId',
                'orderdetail.created_at',
                'orderdetail.quantity',
                'orderdetail.rate',
                'orderdetail.amount',
                'orderdetail.size',
                'product.productname',                
                DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId  LIMIT 1) as photo')
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

                $Total = $cartItem['quantity'] * $cartItem['rate'];

                $rowsHtml .= '
                <tr>
                    <td style="text-align: center">
                        ' . $i . '
                    </td>
                    <td style="text-align: center">
                        ' . $cartItem['productname'] . '
                    </td>
                    <td style="text-align: center">
                        <img width="48" height="48" src="https://thewardrobefashion.in/Product/' . $cartItem->photo . '">
                    </td>
                    <td style="text-align: center">
                        ' . $attr->product_attribute_size . '
                    </td>
                    <td style="text-align: center">
                        ' . $cartItem['quantity'] . '
                    </td>
                    <td style="text-align: center">
                        ' . $cartItem['rate'] . '
                    </td>
                    <td style="text-align: center">
                        ' . $Total . '
                    </td>

                </tr>';
                $i++;
            }

            $templatePath = $root .'/mailers/checkoutmail.html';
            $htmlBody = @file_get_contents($templatePath);

            $address = trim(($order->shiiping_address1 ?? '').', '.($order->shiiping_address2 ?? ''), ', ');

            $replacements = [
                '#order_no'      => $id ?? '',
                '#name'      => $order->shipping_cutomerName ?? '',
                '#email'     => $order->shipping_email ?? '',
                '#mobile'    => $order->shipping_mobile ?? '',
                '#mobile1'   => $order->shipping_mobile1 ?? '',
                '#address'   => e($address),
                '#state'     => e($stateName),
                '#city'      => e($order->shipping_city ?? ''),
                '#pincode'   => e($order->shipping_pincode ?? ''),
                '#amount'    => number_format((float)$order->amount, 2),
                '#netAmount' => number_format((float)$order->netAmount, 2),
                '#tableProductTr' => $rowsHtml,
            ];
            $htmlBody = strtr($htmlBody, $replacements);

            // 6) Send emails (admin + customer) with Laravel Mail
            $subject = "Order Detail From The Wardrobe Fashion Order No #{$id}";
            $fromMail = $sendEmail->strFromMail ?? config('mail.from.address');
            $fromName = $sendEmail->strFromName ?? config('mail.from.name');

             try {
                if ($adminEmail) {
                    Mail::html($htmlBody, function ($m) use ($adminEmail, $subject, $fromMail, $fromName) {
                        $m->to($adminEmail)->subject($subject);
                        
                        if ($fromMail) $m->from($fromMail, $fromName);
                    });
                }

                if (!empty($order->shipping_email)) {
                    Mail::html($htmlBody, function ($m) use ($order, $subject, $fromMail, $fromName) {
                        $m->to($order->shipping_email)->subject($subject);
                        
                        if ($fromMail) $m->from($fromMail, $fromName);
                    });
                }

            } catch (\Throwable $e) {
                Log::error('Checkout email send failed', ['order_id' => $id, 'err' => $e->getMessage()]);
                // continue; don’t block the thank-you page
            }   


            // <!-- $file = str_replace('#tableProductTr', $html, $file);
            // //try{
            // // dd($file);
            // $setting = DB::table("setting")->select('email')->first();
            // $toMail = $setting->email;
            // $to = $toMail;
            // $subject = "Order Detail From The Wardrobe Fashion Order No #".$id;
            // $message = $file;
            
            // $header = "From:" . $SendEmailDetails->strFromMail . "\r\n";
            // $header .= "MIME-Version: 1.0\r\n";
            // $header .= "Content-type: text/html\r\n";
            // $retval = mail($to, $subject, $message, $header);

            // $to = $Order['shipping_email'];
            // $subject = "Order Detail From The Wardrobe Fashion Order No #".$id;
            // $message = $file;
            // $header = "From:" . $SendEmailDetails->strFromMail . "\r\n";
            // $header .= "MIME-Version: 1.0\r\n";
            // $header .= "Content-type: text/html\r\n";

            // mail($to, $subject, $message, $header); -->

        $ORDER_ID = $id;
        $Customer = Customer::where("customerid", $order->customerid)->first();
        $InsertedId =  $Customer->customerid;
        $mobile = $order->shipping_mobile;
        $Setting = Setting::where(["id" => 1])->first();
        $key = $Setting->api_key;
        
        //         $whatsappmsg = "*Dear Customer*,
        
        // Click on the link below to see your order:
        // https://thewardrobefashion.in/Order/$ORDER_ID/{$Customer->guid}
        
        // Regards,
        // Team Wardrobefashion.";

        

        // //$message = "Dear $order->shipping_cutomerName, Your order will be dispatched within 3 working Days. Tracking Id will be soon issue to you. Regards, Team The Wardrobe Fashion.";
        // $message = "Dear Customer, Your order will be dispatched within 3 working Days. Tracking Id will be soon issue to you. Regards, Team The Wardrobe Fashion.";
        // // $customer = new Customer();
        // // $status = $customer->sendWhatsappMessage($MobileNumber, $key, $msg, $InsertedId);
        
        // $customer = new Customer();
        // $status = $customer->sendWhatsappMessage($mobile, $message);
        
        
        // //$message = "Dear $order->shipping_cutomerName, Your order will be dispatched within 3 working Days. Tracking Id will be soon issue to you. Regards, Team The Wardrobe Fashion.";
        // $message = "Dear Customer, Your order will be dispatched within 3 working Days. Tracking Id will be soon issue to you. Regards, Team The Wardrobe Fashion.";
        // // $customer = new Customer();
        // // $status = $customer->sendWhatsappMessage($MobileNumber, $key, $msg, $InsertedId);
        
        // $customer = new Customer();
        // $status = $customer->sendWhatsappMessage("9510081119", $message);
        
        // $whatsappmsg = "*Dear $order->shipping_cutomerName*,\n\nYour Order No : $id.\n\nClick on the link below to see your order:\nhttps://thewardrobefashion.in/Order/$ORDER_ID/{$Customer->guid}\n\nRegards,\nTeam Wardrobefashion.";
        // //Whatsapp
        // $customer = new Customer();
        // $whatsapp = $customer->WhatsappMessage($mobile, $whatsappmsg);
        
        $message = "Dear Customer, Your order will be dispatched within 3 working Days. Tracking Id will be soon issue to you. Regards, Team The Wardrobe Fashion.";

        // $customer = new Customer();
        // $status = $customer->WhatsappMessage($MobileNumber, $key, $msg, $InsertedId);

        $customer = new Customer();
        $customer->sendMessage($mobile, $message, "1707172104144059732");
        $customer->sendMessage("9510081119", $message, "1707172104144059732");
        return view('thankyouPage', [
                'order' => $order,
                'orderDetails' => $OrderDetail,
                'stateName' => $stateName
            ]);

    }

    public function RazorFail()
    {
        return view('paymentFail');
    }
    
    // public function RazorThankYoutest(Request $request, $id)
    // {
        
    //     $order  = Order::where("order_id", $id)->first();
         
    //     $StateName = State::where(["stateId"=>$order->shiiping_state])->first();
    //     $stateName = $StateName->stateName ?? '';

    //     $sendEmail = DB::table('sendemaildetails')->where(['id' => 9])->first();
    //     $adminSetting = DB::table('setting')->select('email')->first();
    //     $adminEmail = $adminSetting->email ?? null;

    //     $root = $_SERVER['DOCUMENT_ROOT'];
        
    //       $OrderDetail = OrderDetail::select(
    //             'orderdetail.orderDetailId',
    //             'orderdetail.orderID',
    //             'orderdetail.productId',
    //             'orderdetail.created_at',
    //             'orderdetail.quantity',
    //             'orderdetail.rate',
    //             'orderdetail.amount',
    //             'orderdetail.size',
    //             'product.productname',                
    //             DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId  LIMIT 1) as photo')
    //         )
    //         ->where(['orderdetail.iStatus' => 1, 'orderdetail.isDelete' => 0, 'orderdetail.orderID' => $id])
    //         ->join('product', 'orderdetail.productId', '=', 'product.productId')
    //         ->get();
    //     return view('thankyouPage_test', [
    //             'order' => $order,
    //             'orderDetails' => $OrderDetail,
    //             'stateName' => $stateName
    //         ]);
    // }
}
