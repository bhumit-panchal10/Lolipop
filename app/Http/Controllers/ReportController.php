<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shipping;
use App\Models\Customer;
use App\Models\Courier;
use App\Models\State;
use App\Models\Setting;
use App\Models\ProductAttributes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function paymentReport(Request $request)
    {
        // dd($request);
        try {
            $FromDate = $request->fromdate;
            $ToDate = $request->todate;

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
                'state.stateName',
                'order.docketNo',
                'order.isDispatched',

            )
                ->orderBy('order_id', 'desc')
                ->where(['order.iStatus' => 1, 'order.isDelete' => 0, 'order.isDispatched' => 1])
                ->when($request->fromdate, fn($query, $FromDate) => $query
                    ->where('order.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
                ->when($request->todate, fn($query, $ToDate) => $query
                    ->where('order.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
                ->join('courier', 'order.courier', '=', 'courier.id')
                ->join('state', 'order.shiiping_state', '=', 'state.stateId')
                ->paginate(15);
            //dd($Dispatched);

            return view('order.paymentReport', compact('Dispatched', 'FromDate', 'ToDate'));
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function orderTracking(Request $request)
    {
        try {
            $FromDate = $request->fromdate;
            $ToDate = $request->todate;
            $Mobile = $request->mobile;
            $Name = $request->strName;

            $Dispatched = Order::orderBy('order_id', 'desc')
                ->where(['order.iStatus' => 1, 'order.isDelete' => 0, 'order.isDispatched' => 1])
                ->when($request->fromdate, fn($query, $FromDate) => $query
                    ->where('order.created_at', '>=', date('Y-m-d 00:00:00', strtotime($FromDate))))
                ->when($request->todate, fn($query, $ToDate) => $query
                    ->where('order.created_at', '<=', date('Y-m-d 23:59:59', strtotime($ToDate))))
                ->when($request->mobile, fn($query, $Mobile) => $query
                    ->where('order.shipping_mobile', '=', $Mobile))
                ->when($request->strName, fn($query, $Name) => $query
                    ->where('order.shipping_cutomerName', 'like', '%' . $Name . '%'))
                ->join('courier', 'order.courier', '=', 'courier.id')
                ->join('state', 'order.shiiping_state', '=', 'state.stateId')
                ->paginate(15);
            //dd($Dispatched);

            return view('order.orderTracking', compact('Dispatched', 'FromDate', 'ToDate', 'Name'));
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function searchCustomer(Request $request)
    {
        try {
            $OrderNo = $request->order_no;
            $Name = $request->strName;
            $Mobile = $request->strMobile;
            $Courier = Courier::orderBy('id', 'desc')->where(['iStatus' => 1, 'isDelete' => 0])->get();
            $datas = [];
            $count = [];
            if ($request->strName != "" || $request->strMobile != "" || $request->order_no != "") {
                $datas = Order::select(
                    'order.*',
                    'courier.name as courier_name',
                    'courier.url',
                )
                    ->orderBy('order_id', 'desc')
                    ->where(['order.iStatus' => 1, 'order.isDelete' => 0])
                    ->when($request->order_no, fn($query, $OrderNo) => $query
                        ->Where('order.order_id', '=', $OrderNo))
                    ->when($request->strName, fn($query, $Name) => $query
                        ->Where('order.shipping_cutomerName', 'LIKE', '%' . $Name . '%'))
                    ->when($request->strMobile, fn($query, $Mobile) => $query
                        ->Where('order.shipping_mobile', 'LIKE', '%' . $Mobile . '%'))
                    ->leftjoin('courier', 'order.courier', '=', 'courier.id')
                    ->paginate(15);
                // dd($datas);
                $count = $datas->count();
            }

            return view('order.searchcustomer', compact('Name', 'Mobile', 'datas', 'Courier', 'count', 'OrderNo'));
        } catch (\Throwable $th) {

            // Rollback & Return Error Message
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function send_whatsapp_tracking_link(Request $request, $id)
    {
        // dd($request);

        try {
            $order = Order::where("order_id", $id)->first();

            if (! $order) {
                return redirect()->back()->with('error', 'Order not found.');
            }



            // Get state name safely
            $StateName = State::where(["stateId" => $order->shiiping_state])->first();
            $stateName = $StateName->stateName ?? '';

            $ORDER_ID = $id;
            $Customer = Customer::where("customerid", $order->customerid)->first();

            // If customer not found, still try using order shipping_mobile / email
            $customerEmail = $order->shipping_email;
            $customerGuid = $Customer->guid ?? null;
            $mobile = $order->shipping_mobile;

            $Setting = Setting::where(["id" => 1])->first();
            $Courier = Courier::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $order->courier])->first();
            $shippingName  = $order->shipping_cutomerName;
            $urlToClient = "";

            if ($order->courier == 1) {
                $trackingUrl = $Courier->url;
            } elseif ($order->courier == 2) {
                $trackingUrl = $Courier->url . $request->docketNo;
            } else {
                $trackingUrl = $Courier->url;
            }

            $urlToClient = $trackingUrl;
            if ($order->courier == 1) {
                $whatsappmsg = "*Dear $shippingName*,\n\nYour parcel has been dispatch.\n\nTo track your order, Visit below link.\n\nLink : $urlToClient\n\nYour Awb No : $order->docketNo\n\nRegards,\nTeam Lolipop Kidswear.";
            } elseif ($order->courier == 2) {
                $whatsappmsg = "*Dear $shippingName*,\n\nClick on the below link to track your order:\n$urlToClient\n\nRegards,\nTeam Lolipop Kidswear.";
            } else {
                $whatsappmsg = "*Dear $shippingName*,\n\nYour parcel has been dispatch.\n\nTo track your order, Visit below link.\n\nLink : $urlToClient\n\nYour Article No : $order->docketNo\n\nRegards,\nTeam Lolipop Kidswear.";
            }

            // $trackingUrl = $Courier->url . $order->docketNo;
            // $whatsappmsg = "*Dear Customer*,\n\nClick on the below link to track your order:\n" . $trackingUrl . "\n\nRegards,\nTeam Wardrobefashion.";

            // --- Send WhatsApp (existing method) ---


            $sendEmail = DB::table('sendemaildetails')->where(['id' => 10])->first();
            // --- Prepare email content ---
            $subject = "Your Order #{$ORDER_ID} - Track Your Order";
            $fromMail = $sendEmail->strFromMail;
            $fromName = $sendEmail->strFromName ?? config('mail.from.name') ?? 'Wardrobefashion';
            // $ccEmail = 'dev4.apolloinfotech@gmail.com'; // <-- your CC email here

            //code to get body from html:
            //code of getting bode end here
            // simple HTML email body
            $DocketType = "Docket No";
            $customer = new Customer();
            if ($order->courier == 1) {
                $DocketType = "AWB No";
                // Tirupati (no docket number in URL)

                $status = $customer->tirupatiMsg($mobile, $order->docketNo);
                $message = "Dear Customer, Click on the link below to track your order : http://www.shreetirupaticourier.net Awb No : " . $order->docketNo . " Regards, Team The Wardrobe.";
                $customer->WhatsappMessage($mobile, $message);
            } elseif ($order->courier == 2) {
                // Other couriers (include docket number in message)
                $DocketType = "Docket No";

                $status = $customer->delhiveryMsg($mobile, $order->docketNo);
                $message = "Dear Customer, Click on the link below to track your order: https://www.delhivery.com/track/package/" . $order->docketNo . " Regards, Team Lolipop Kidswear.";
                $customer->WhatsappMessage($mobile, $message);
            } else {
                // Other couriers (include docket number in message)
                $DocketType = "Artical No";

                $status = $customer->indianpostMsg($mobile, $order->docketNo);
                $message = "Dear Customer, Click on the link below to track your order : www.indiapost.gov.in Awb No : " . $order->docketNo . " Regards, Team The Wardrobe.";
                $customer->WhatsappMessage($mobile, $message);
            }

            $root = $_SERVER['DOCUMENT_ROOT'];
            $htmlBody = file_get_contents($root . '/mailers/dispatchemail.html');
            $htmlBody = str_replace(
                ['#orderNo', '#courierName', '#docketNo', '#link', '#docketType'],
                [$order->order_id, $Courier->name ?? '', $order->docketNo, $trackingUrl, $DocketType],
                $htmlBody
            );


            // --- Send email to customer (if email present) ---
            if (!empty($customerEmail)) {
                try {
                    Mail::html($htmlBody, function ($message) use ($customerEmail, $subject, $fromMail, $fromName) {
                        $message->to($customerEmail)
                            ->subject($subject);

                        if ($fromMail) {
                            $message->from($fromMail, $fromName);
                        }

                        // if (!empty($ccEmail)) {
                        //     // allow comma-separated or array
                        //     if (is_string($ccEmail) && strpos($ccEmail, ',') !== false) {
                        //         $ccs = array_map('trim', explode(',', $ccEmail));
                        //         $message->cc($ccs);
                        //     } else {
                        //         $message->cc($ccEmail);
                        //     }
                        // }
                    });
                } catch (\Throwable $e) {
                    Log::error('Customer email send failed', [
                        'order_id' => $ORDER_ID,
                        'email' => $customerEmail,
                        'err' => $e->getMessage()
                    ]);
                    // Do not abort; return success for WhatsApp (or partial)
                }
            } else {
                Log::info('No customer email available to send tracking link', ['order_id' => $ORDER_ID]);
            }

            return back()->with('success', 'Link Send Successfully.');
        } catch (\Throwable $th) {
            // Rollback & Return Error Message
            return redirect()->back()->with('error', $th->getMessage());
        }
    }


    public function send_confirmation_message(Request $request, $id)
    {
        // dd($request);
        $order  = Order::where("order_id", $id)->first();

        $StateName = State::where(["stateId" => $order->shiiping_state])->first();
        $stateName = $StateName->stateName ?? '';

        $sendEmail = DB::table('sendemaildetails')->where(['id' => 9])->first();
        $adminSetting = DB::table('setting')->select('email')->first();
        $adminEmail = $adminSetting->email ?? null;

        $root = $_SERVER['DOCUMENT_ROOT'];

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
                ->where([
                    "product_id" => $cartItem->productId,
                    'product_attribute_size' => $cartItem->size,
                    // 'id' => $cartItem->size
                ])
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
                        <img width="48" height="48" src="http://127.0.0.1:8000/Product/' . $cartItem->photo . '">
                    </td>
                    <td style="text-align: center">
                        ' . $attr->size . '
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

        $templatePath = $root . '/mailers/checkoutmail.html';
        $htmlBody = @file_get_contents($templatePath);

        $address = trim(($order->shiiping_address1 ?? '') . ', ' . ($order->shiiping_address2 ?? ''), ', ');

        $awb_no = $order->docketNo ?? '';
        // dd($order);
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

            '#awb_no' => $order->docketNo ?? '',
        ];
        $htmlBody = strtr($htmlBody, $replacements);
        // dd($htmlBody);

        // 6) Send emails (admin + customer) with Laravel Mail
        $subject = "Order Detail From Lolipop Kidswear Order No #{$id}";
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


        $Customer = Customer::where("customerid", $order->customerid)->first();
        $InsertedId =  $Customer->customerid;
        $mobile = $order->shipping_mobile;
        $Setting = Setting::where(["id" => 1])->first();
        // $key = $Setting->api_key;


        // $whatsappmsg = "*Dear $order->shipping_cutomerName*,\n\nYour Order No : $id.\n\nClick on the link below to see your order:\nhttp://127.0.0.1:8000//Order/$ORDER_ID/{$Customer->guid}\n\nRegards,\nTeam Wardrobefashion.";

        // $message = "Dear Customer, Your order will be dispatched within 3 working Days. Tracking Id will be soon issue to you. Regards, Team Lolipop Kidswear.";

        // $customer = new Customer();
        // $status = $customer->WhatsappMessage($MobileNumber, $key, $msg, $InsertedId);

        // $customer = new Customer();
        //$status = $customer->WhatsappMessage($mobile, $message);
        // $customer->sendMessage($mobile, $message, "1707172104144059732");

        // $message = "Dear Customer, Your order will be dispatched within 3 working Days. Tracking Id will be soon issue to you. Regards, Team Lolipop Kidswear.";

        // $customer = new Customer();
        // $status = $customer->WhatsappMessage($MobileNumber, $key, $msg, $InsertedId);

        // $customer = new Customer();
        // $status = $customer->sendMessage("9510081119", $message, "1707172104144059732");

        //Whatsapp
        //$whatsapp = $customer->WhatsappMessage($mobile, $whatsappmsg);


        // dd($whatsappmsg);
        // $customer = new Customer();
        // $message = "Dear Customer, Your order will be dispatched within 3 working Days. Tracking Id will be soon issue to you. Regards, Team Lolipop Kidswear.";
        // $status = $customer->sendWhatsappMessage($mobile, $message);
        // $status = $customer->sendMessage($mobile, $message,);
        // $customer = new Customer();
        // $status = $customer->sendWhatsappMessage($MobileNumber, $key, $msg, $InsertedId);



        // dd($message);


        // $message = "Dear Customer, Your order will be dispatched within 3 working Days. Tracking Id will be soon issue to you. Regards, Team Lolipop Kidswear.";




        return back()->with('success', 'Mail Send Successfully.');
    }

    // public function send_whatsapp_tracking_link(Request $request, $id)
    // {
    //     // dd($request);

    //     try {
    //         $order = Order::where("order_id", $id)->first();

    //         if (! $order) {
    //             return redirect()->back()->with('error', 'Order not found.');
    //         }



    //         // Get state name safely
    //         $StateName = State::where(["stateId" => $order->shiiping_state])->first();
    //         $stateName = $StateName->stateName ?? '';

    //         $ORDER_ID = $id;
    //         $Customer = Customer::where("customerid", $order->customerid)->first();

    //         // If customer not found, still try using order shipping_mobile / email
    //         $customerEmail = $order->shipping_email;
    //         $customerGuid = $Customer->guid ?? null;
    //         $mobile = $order->shipping_mobile;

    //         $Setting = Setting::where(["id" => 1])->first();
    //         $Courier = Courier::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $order->courier])->first();
    //         $shippingName  = $order->shipping_cutomerName;
    //         $urlToClient = "";
    //         if ($order->courier == 1) {
    //             $trackingUrl = $Courier->url;
    //         } else {
    //             $trackingUrl = $Courier->url . $request->docketNo;
    //         }
    //         $urlToClient = $trackingUrl;
    //         if ($order->courier == 1) {
    //             $whatsappmsg = "*Dear $shippingName*,\n\nYour parcel has been dispatch.\n\nTo track your order, Visit below link.\n\nLink : $urlToClient\n\nYour Awb No : $order->docketNo\n\nRegards,\nTeam Lolipop Kidswear.";
    //         } else {
    //             $whatsappmsg = "*Dear $shippingName*,\n\nClick on the below link to track your order:\n$urlToClient\n\nRegards,\nTeam Lolipop Kidswear.";
    //         }

    //         // $trackingUrl = $Courier->url . $order->docketNo;
    //         // $whatsappmsg = "*Dear Customer*,\n\nClick on the below link to track your order:\n" . $trackingUrl . "\n\nRegards,\nTeam Wardrobefashion.";

    //         // --- Send WhatsApp (existing method) ---
    //         try {
    //             // Assuming Customer::WhatsappMessage exists and handles sending
    //             $customerModel = new Customer();
    //             $whatsapp = $customerModel->WhatsappMessage($mobile, $whatsappmsg);
    //         } catch (\Throwable $e) {
    //             Log::error('WhatsApp send failed', [
    //                 'order_id' => $ORDER_ID,
    //                 'mobile' => $mobile,
    //                 'err' => $e->getMessage()
    //             ]);
    //             // Continue — we still want to attempt email
    //         }

    //         $sendEmail = DB::table('sendemaildetails')->where(['id' => 10])->first();
    //         // --- Prepare email content ---
    //         $subject = "Your Order #{$ORDER_ID} - Track Your Order";
    //         $fromMail = $sendEmail->strFromMail;
    //         $fromName = $sendEmail->strFromName ?? config('mail.from.name') ?? 'Wardrobefashion';
    //         $ccEmail = 'dev4.apolloinfotech@gmail.com'; // <-- your CC email here

    //         // simple HTML email body
    //         $customer = new Customer();
    //         if ($order->courier == 1) {
    //             // Tirupati (no docket number in URL)
    //             $htmlBody = '
    //             <p>Dear ' . e($Customer->firstname ?? $order->shipping_cutomerName ?? 'Customer') . ',</p>
    //             <p>Click the below link to track your order:</p>
    //             <p><a href="' . e($trackingUrl) . '">' . e($trackingUrl) . '</a></p>
    //             <p>Your AWB No: ' . e($order->docketNo) . '</p>
    //             <p>Regards,<br/>Team Wardrobefashion</p>
    //         ';
    //             $status = $customer->tirupatiMsg($mobile, $order->docketNo);
    //             $message = "Dear Customer, Click on the link below to track your order : http://www.shreetirupaticourier.net Awb No : " . $order->docketNo . " Regards, Team The Wardrobe.";
    //             $customer->sendWhatsappMessage($mobile, $message);
    //         } else {
    //             // Other couriers (include docket number in message)
    //             $htmlBody = '
    //             <p>Dear ' . e($Customer->firstname ?? $order->shipping_cutomerName ?? 'Customer') . ',</p>
    //             <p>Your parcel has been dispatched.</p>
    //             <p>To track your order, visit the link below:</p>
    //             <p><a href="' . e($trackingUrl) . '">' . e($trackingUrl) . '</a></p>
    //             <p>Regards,<br/>Team Wardrobefashion</p>
    //         ';
    //             $status = $customer->delhiveryMsg($mobile, $order->docketNo);
    //             $message = "Dear Customer, Click on the link below to track your order: https://www.delhivery.com/track/package/" . $order->docketNo . " Regards, Team Lolipop Kidswear.";
    //             $customer->sendWhatsappMessage($mobile, $message);
    //         }



    //         // --- Send email to customer (if email present) ---
    //         if (!empty($customerEmail)) {
    //             try {
    //                 Mail::html($htmlBody, function ($message) use ($customerEmail, $subject, $fromMail, $fromName, $ccEmail) {
    //                     $message->to($customerEmail)
    //                         ->subject($subject);

    //                     if ($fromMail) {
    //                         $message->from($fromMail, $fromName);
    //                     }

    //                     // if (!empty($ccEmail)) {
    //                     //     // allow comma-separated or array
    //                     //     if (is_string($ccEmail) && strpos($ccEmail, ',') !== false) {
    //                     //         $ccs = array_map('trim', explode(',', $ccEmail));
    //                     //         $message->cc($ccs);
    //                     //     } else {
    //                     //         $message->cc($ccEmail);
    //                     //     }
    //                     // }
    //                 });
    //             } catch (\Throwable $e) {
    //                 Log::error('Customer email send failed', [
    //                     'order_id' => $ORDER_ID,
    //                     'email' => $customerEmail,
    //                     'err' => $e->getMessage()
    //                 ]);
    //                 // Do not abort; return success for WhatsApp (or partial)
    //             }
    //         } else {
    //             Log::info('No customer email available to send tracking link', ['order_id' => $ORDER_ID]);
    //         }

    //         return back()->with('success', 'Link Send Successfully.');
    //     } catch (\Throwable $th) {
    //         // Rollback & Return Error Message
    //         return redirect()->back()->with('error', $th->getMessage());
    //     }
    // }
    // public function send_confirmation_message(Request $request, $id)
    // {
    //     // dd($request);
    //     $order  = Order::where("order_id", $id)->first();

    //     $StateName = State::where(["stateId" => $order->shiiping_state])->first();
    //     $stateName = $StateName->stateName ?? '';

    //     $sendEmail = DB::table('sendemaildetails')->where(['id' => 9])->first();
    //     $adminSetting = DB::table('setting')->select('email')->first();
    //     $adminEmail = $adminSetting->email ?? null;

    //     $root = $_SERVER['DOCUMENT_ROOT'];

    //     $OrderDetail = OrderDetail::select(
    //         'orderdetail.orderDetailId',
    //         'orderdetail.orderID',
    //         'orderdetail.productId',
    //         'orderdetail.created_at',
    //         'orderdetail.quantity',
    //         'orderdetail.rate',
    //         'orderdetail.amount',
    //         'orderdetail.size',
    //         'product.productname',
    //         DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId  LIMIT 1) as photo')
    //     )
    //         ->where(['orderdetail.iStatus' => 1, 'orderdetail.isDelete' => 0, 'orderdetail.orderID' => $id])
    //         ->join('product', 'orderdetail.productId', '=', 'product.productId')
    //         ->get();

    //     $rowsHtml = '';
    //     $i = 1;
    //     foreach ($OrderDetail as $cartItem) {

    //         $attr = ProductAttributes::orderBy('id', 'desc')
    //             ->where(["product_id" => $cartItem->productId, 'id' => $cartItem->size])
    //             ->first();

    //         $Total = $cartItem['quantity'] * $cartItem['rate'];

    //         $rowsHtml .= '
    //             <tr>
    //                 <td style="text-align: center">
    //                     ' . $i . '
    //                 </td>
    //                 <td style="text-align: center">
    //                     ' . $cartItem['productname'] . '
    //                 </td>
    //                 <td style="text-align: center">
    //                     <img width="48" height="48" src="http://127.0.0.1:8000//Product/' . $cartItem->photo . '">
    //                 </td>
    //                 <td style="text-align: center">
    //                     ' . $attr->product_attribute_size . '
    //                 </td>
    //                 <td style="text-align: center">
    //                     ' . $cartItem['quantity'] . '
    //                 </td>
    //                 <td style="text-align: center">
    //                     ' . $cartItem['rate'] . '
    //                 </td>
    //                 <td style="text-align: center">
    //                     ' . $Total . '
    //                 </td>

    //             </tr>';
    //         $i++;
    //     }

    //     $templatePath = $root . '/mailers/checkoutmail.html';
    //     $htmlBody = @file_get_contents($templatePath);

    //     $address = trim(($order->shiiping_address1 ?? '') . ', ' . ($order->shiiping_address2 ?? ''), ', ');

    //     $awb_no = $order->docketNo ?? '';
    //     // dd($order);
    //     $replacements = [
    //         '#order_no'      => $id ?? '',
    //         '#name'      => $order->shipping_cutomerName ?? '',
    //         '#email'     => $order->shipping_email ?? '',
    //         '#mobile'    => $order->shipping_mobile ?? '',
    //         '#mobile1'   => $order->shipping_mobile1 ?? '',
    //         '#address'   => e($address),
    //         '#state'     => e($stateName),
    //         '#city'      => e($order->shipping_city ?? ''),
    //         '#pincode'   => e($order->shipping_pincode ?? ''),
    //         '#amount'    => number_format((float)$order->amount, 2),
    //         '#netAmount' => number_format((float)$order->netAmount, 2),
    //         '#tableProductTr' => $rowsHtml,

    //         '#awb_no' => $order->docketNo ?? '',
    //     ];
    //     $htmlBody = strtr($htmlBody, $replacements);
    //     // dd($htmlBody);

    //     // 6) Send emails (admin + customer) with Laravel Mail
    //     $subject = "Order Detail From Lolipop Kidswear Order No #{$id}";
    //     $fromMail = $sendEmail->strFromMail ?? config('mail.from.address');
    //     $fromName = $sendEmail->strFromName ?? config('mail.from.name');

    //     try {
    //         if ($adminEmail) {
    //             Mail::html($htmlBody, function ($m) use ($adminEmail, $subject, $fromMail, $fromName) {
    //                 $m->to($adminEmail)->subject($subject);
    //                 if ($fromMail) $m->from($fromMail, $fromName);
    //             });
    //         }

    //         if (!empty($order->shipping_email)) {
    //             Mail::html($htmlBody, function ($m) use ($order, $subject, $fromMail, $fromName) {
    //                 $m->to($order->shipping_email)->subject($subject);
    //                 if ($fromMail) $m->from($fromMail, $fromName);
    //             });
    //         }
    //     } catch (\Throwable $e) {
    //         Log::error('Checkout email send failed', ['order_id' => $id, 'err' => $e->getMessage()]);
    //         // continue; don’t block the thank-you page
    //     }

    //     $ORDER_ID = $id;
    //     $Customer = Customer::where("customerid", $order->customerid)->first();
    //     $InsertedId =  $Customer->customerid;
    //     $mobile = $order->shipping_mobile;
    //     $Setting = Setting::where(["id" => 1])->first();
    //     $key = $Setting->api_key;

    //     $textMessage = "Dear Customer, Your order will be dispatched within 3 working Days. Tracking Id will be soon issue to you. Regards, Team Lolipop Kidswear.";

    //         $cust = new Customer();
    //         $cust->sendMessage($mobile, $textMessage, "1707176528866290420");
    //         $cust->sendWhatsappMessage($mobile, $textMessage);

    //     $whatsappmsg = "Dear Customer, Your order will be dispatched within 3 working Days. Tracking Id will be soon issue to you. Regards, Team Lolipop Kidswear.";

    //         // $whatsappmsg = "*Dear {$order->shipping_cutomerName}*,\n\nYour Order No : $id.\n\nClick below to view your order:\nhttp://127.0.0.1:8000//Order/$ORDER_ID/{$Customer->guid}\n\nRegards,\nTeam WardrobeFashion.";

    //       $cust->WhatsappMessage($mobile, $whatsappmsg);

    //      // dd($whatsappmsg);
    //     // $customer = new Customer();
    //     // $message = "Dear Customer, Your order will be dispatched within 3 working Days. Tracking Id will be soon issue to you. Regards, Team Lolipop Kidswear.";
    //     // $status = $customer->sendWhatsappMessage($mobile, $message);
    //     // $status = $customer->sendMessage($mobile, $message,);


    //     return back()->with('success', 'Mail Send Successfully.');
    // }

    // public function send_whatsapp_tracking_link(Request $request, $id)
    // {
    //     // dd($request);

    //     try {
    //         $order = Order::where("order_id", $id)->first();

    //         if (! $order) {
    //             return redirect()->back()->with('error', 'Order not found.');
    //         }



    //         // Get state name safely
    //         $StateName = State::where(["stateId" => $order->shiiping_state])->first();
    //         $stateName = $StateName->stateName ?? '';

    //         $ORDER_ID = $id;
    //         $Customer = Customer::where("customerid", $order->customerid)->first();

    //         // If customer not found, still try using order shipping_mobile / email
    //         $customerEmail = $order->shipping_email;
    //         $customerGuid = $Customer->guid ?? null;
    //         $mobile = $order->shipping_mobile;

    //         $Setting = Setting::where(["id" => 1])->first();
    //         $Courier = Courier::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $order->courier])->first();
    //         $shippingName  = $order->shipping_cutomerName;
    //         $urlToClient = "";
    //         if ($order->courier == 1) {
    //             $trackingUrl = $Courier->url;
    //         } else {
    //             $trackingUrl = $Courier->url . $request->docketNo;
    //         }
    //         $urlToClient = $trackingUrl;
    //         if ($order->courier == 1) {
    //             $whatsappmsg = "*Dear $shippingName*,\n\nYour parcel has been dispatch.\n\nTo track your order, Visit below link.\n\nLink : $urlToClient\n\nYour Awb No : $order->docketNo\n\nRegards,\nTeam Lolipop Kidswear.";
    //         } else {
    //             $whatsappmsg = "*Dear $shippingName*,\n\nClick on the below link to track your order:\n$urlToClient\n\nRegards,\nTeam Lolipop Kidswear.";
    //         }

    //         // $trackingUrl = $Courier->url . $order->docketNo;
    //         // $whatsappmsg = "*Dear Customer*,\n\nClick on the below link to track your order:\n" . $trackingUrl . "\n\nRegards,\nTeam Wardrobefashion.";

    //         // --- Send WhatsApp (existing method) ---
    //         try {
    //             // Assuming Customer::WhatsappMessage exists and handles sending
    //             $customerModel = new Customer();
    //             $whatsapp = $customerModel->WhatsappMessage($mobile, $whatsappmsg);
    //         } catch (\Throwable $e) {
    //             Log::error('WhatsApp send failed', [
    //                 'order_id' => $ORDER_ID,
    //                 'mobile' => $mobile,
    //                 'err' => $e->getMessage()
    //             ]);
    //             // Continue — we still want to attempt email
    //         }

    //         $sendEmail = DB::table('sendemaildetails')->where(['id' => 10])->first();
    //         // --- Prepare email content ---
    //         $subject = "Your Order #{$ORDER_ID} - Track Your Order";
    //         $fromMail = $sendEmail->strFromMail;
    //         $fromName = $sendEmail->strFromName ?? config('mail.from.name') ?? 'Wardrobefashion';
    //         $ccEmail = 'dev4.apolloinfotech@gmail.com'; // <-- your CC email here

    //         // simple HTML email body
    //         if ($order->courier == 1) {
    //             // Tirupati (no docket number in URL)
    //             $htmlBody = '
    //             <p>Dear ' . e($Customer->firstname ?? $order->shipping_cutomerName ?? 'Customer') . ',</p>
    //             <p>Click the below link to track your order:</p>
    //             <p><a href="' . e($trackingUrl) . '">' . e($trackingUrl) . '</a></p>
    //             <p>Your AWB No: ' . e($order->docketNo) . '</p>
    //             <p>Regards,<br/>Team Wardrobefashion</p>
    //         ';
    //         } else {
    //             // Other couriers (include docket number in message)
    //             $htmlBody = '
    //             <p>Dear ' . e($Customer->firstname ?? $order->shipping_cutomerName ?? 'Customer') . ',</p>
    //             <p>Your parcel has been dispatched.</p>
    //             <p>To track your order, visit the link below:</p>
    //             <p><a href="' . e($trackingUrl) . '">' . e($trackingUrl) . '</a></p>
    //             <p>Regards,<br/>Team Wardrobefashion</p>
    //         ';
    //         }



    //         // --- Send email to customer (if email present) ---
    //         if (!empty($customerEmail)) {
    //             try {
    //                 Mail::html($htmlBody, function ($message) use ($customerEmail, $subject, $fromMail, $fromName, $ccEmail) {
    //                     $message->to($customerEmail)
    //                         ->subject($subject);

    //                     if ($fromMail) {
    //                         $message->from($fromMail, $fromName);
    //                     }

    //                     // if (!empty($ccEmail)) {
    //                     //     // allow comma-separated or array
    //                     //     if (is_string($ccEmail) && strpos($ccEmail, ',') !== false) {
    //                     //         $ccs = array_map('trim', explode(',', $ccEmail));
    //                     //         $message->cc($ccs);
    //                     //     } else {
    //                     //         $message->cc($ccEmail);
    //                     //     }
    //                     // }
    //                 });
    //             } catch (\Throwable $e) {
    //                 Log::error('Customer email send failed', [
    //                     'order_id' => $ORDER_ID,
    //                     'email' => $customerEmail,
    //                     'err' => $e->getMessage()
    //                 ]);
    //                 // Do not abort; return success for WhatsApp (or partial)
    //             }
    //         } else {
    //             Log::info('No customer email available to send tracking link', ['order_id' => $ORDER_ID]);
    //         }

    //         return back()->with('success', 'Link Send Successfully.');
    //     } catch (\Throwable $th) {
    //         // Rollback & Return Error Message
    //         return redirect()->back()->with('error', $th->getMessage());
    //     }
    // }

    // public function send_whatsapp_tracking_link(Request $request,$id)
    //  {
    //     //  dd($request);

    //   try {
    //         $order = Order::where("order_id", $id)->first();

    //     if (! $order) {
    //         return redirect()->back()->with('error', 'Order not found.');
    //     }

    //     // Get state name safely
    //     $StateName = State::where(["stateId" => $order->shiiping_state])->first();
    //     $stateName = $StateName->stateName ?? '';

    //     $ORDER_ID = $id;
    //     $Customer = Customer::where("customerid", $order->customerid)->first();

    //     // If customer not found, still try using order shipping_mobile / email
    //     $customerEmail = $order->shipping_email;
    //     $customerGuid = $Customer->guid ?? null;
    //     $mobile = $order->shipping_mobile;

    //     $Setting = Setting::where(["id" => 1])->first();
    //     $Courier = Courier::where(['iStatus' => 1, 'isDelete' => 0, 'id' => $order->courier])->first();
    //     $shippingName  = $order->shipping_cutomerName;
    //     $urlToClient = "";
    //     if ($order->courier == 1) {
    //         $trackingUrl = $Courier->url;
    //     } else {
    //         $trackingUrl = $Courier->url . $request->docketNo;
    //     }
    //     $urlToClient = $trackingUrl;
    //     if ($order->courier == 1) {
    //         $whatsappmsg = "*Dear $shippingName*,\n\nYour parcel has been dispatch.\n\nTo track your order, Visit below link.\n\nLink : $urlToClient\n\nYour Awb No : $order->docketNo\n\nRegards,\nTeam Lolipop Kidswear.";
    //     } else {
    //         $whatsappmsg = "*Dear $shippingName*,\n\nClick on the below link to track your order:\n$urlToClient\n\nRegards,\nTeam Lolipop Kidswear.";
    //     }

    //     // $trackingUrl = $Courier->url . $order->docketNo;
    //     // $whatsappmsg = "*Dear Customer*,\n\nClick on the below link to track your order:\n" . $trackingUrl . "\n\nRegards,\nTeam Wardrobefashion.";

    //     // --- Send WhatsApp (existing method) ---
    //     try {
    //         // Assuming Customer::WhatsappMessage exists and handles sending
    //         $customerModel = new Customer();
    //         $whatsapp = $customerModel->WhatsappMessage($mobile, $whatsappmsg);
    //     } catch (\Throwable $e) {
    //         Log::error('WhatsApp send failed', [
    //             'order_id' => $ORDER_ID,
    //             'mobile' => $mobile,
    //             'err' => $e->getMessage()
    //         ]);
    //         // Continue — we still want to attempt email
    //     }

    //     $sendEmail = DB::table('sendemaildetails')->where(['id' => 10])->first();
    //     // --- Prepare email content ---
    //     $subject = "Your Order #{$ORDER_ID} - Track Your Order";
    //     $fromMail = $sendEmail->strFromMail;
    //     $fromName = $sendEmail->strFromName ?? config('mail.from.name') ?? 'Wardrobefashion';
    //     $ccEmail = 'dev2.apolloinfotech@gmail.com'; // <-- your CC email here

    //     // simple HTML email body
    //     if ($order->courier == 1) {
    //         // Tirupati (no docket number in URL)
    //         $htmlBody = '
    //             <p>Dear ' . e($Customer->firstname ?? $order->shipping_cutomerName ?? 'Customer') . ',</p>
    //             <p>Click the below link to track your order:</p>
    //             <p><a href="' . e($trackingUrl) . '">' . e($trackingUrl) . '</a></p>
    //             <p>Regards,<br/>Team Wardrobefashion</p>
    //         ';
    //     } else {
    //         // Other couriers (include docket number in message)
    //         $htmlBody = '
    //             <p>Dear ' . e($Customer->firstname ?? $order->shipping_cutomerName ?? 'Customer') . ',</p>
    //             <p>Your parcel has been dispatched.</p>
    //             <p>To track your order, visit the link below:</p>
    //             <p><a href="' . e($trackingUrl) . '">' . e($trackingUrl) . '</a></p>
    //             <p>Your AWB No: ' . e($order->docketNo) . '</p>
    //             <p>Regards,<br/>Team Wardrobefashion</p>
    //         ';
    //     }



    //     // --- Send email to customer (if email present) ---
    //     if (!empty($customerEmail)) {
    //         try {
    //             Mail::html($htmlBody, function ($message) use ($customerEmail, $subject, $fromMail, $fromName, $ccEmail) {
    //                 $message->to($customerEmail)
    //                         ->subject($subject);

    //                 if ($fromMail) {
    //                     $message->from($fromMail, $fromName);
    //                 }

    //                 // if (!empty($ccEmail)) {
    //                 //     // allow comma-separated or array
    //                 //     if (is_string($ccEmail) && strpos($ccEmail, ',') !== false) {
    //                 //         $ccs = array_map('trim', explode(',', $ccEmail));
    //                 //         $message->cc($ccs);
    //                 //     } else {
    //                 //         $message->cc($ccEmail);
    //                 //     }
    //                 // }
    //             });
    //         } catch (\Throwable $e) {
    //             Log::error('Customer email send failed', [
    //                 'order_id' => $ORDER_ID,
    //                 'email' => $customerEmail,
    //                 'err' => $e->getMessage()
    //             ]);
    //             // Do not abort; return success for WhatsApp (or partial)
    //         }
    //     } else {
    //         Log::info('No customer email available to send tracking link', ['order_id' => $ORDER_ID]);
    //     }

    //     return back()->with('success', 'Link Send Successfully.');

    //   } catch (\Throwable $th) {
    //         // Rollback & Return Error Message
    //         return redirect()->back()->with('error', $th->getMessage());
    //     }
    // }

    // public function send_confirmation_message(Request $request, $id)
    // {
    //     // dd($request);
    //     $order  = Order::where("order_id", $id)->first();

    //     $StateName = State::where(["stateId" => $order->shiiping_state])->first();
    //     $stateName = $StateName->stateName ?? '';

    //     $sendEmail = DB::table('sendemaildetails')->where(['id' => 9])->first();
    //     $adminSetting = DB::table('setting')->select('email')->first();
    //     $adminEmail = $adminSetting->email ?? null;

    //     $root = $_SERVER['DOCUMENT_ROOT'];

    //     $OrderDetail = OrderDetail::select(
    //         'orderdetail.orderDetailId',
    //         'orderdetail.orderID',
    //         'orderdetail.productId',
    //         'orderdetail.created_at',
    //         'orderdetail.quantity',
    //         'orderdetail.rate',
    //         'orderdetail.amount',
    //         'orderdetail.size',
    //         'product.productname',
    //         DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId  LIMIT 1) as photo')
    //     )
    //         ->where(['orderdetail.iStatus' => 1, 'orderdetail.isDelete' => 0, 'orderdetail.orderID' => $id])
    //         ->join('product', 'orderdetail.productId', '=', 'product.productId')
    //         ->get();

    //     $rowsHtml = '';
    //     $i = 1;
    //     foreach ($OrderDetail as $cartItem) {

    //         $attr = ProductAttributes::orderBy('id', 'desc')
    //             ->where(["product_id" => $cartItem->productId, 'id' => $cartItem->size])
    //             ->first();

    //         $Total = $cartItem['quantity'] * $cartItem['rate'];

    //         $rowsHtml .= '
    //             <tr>
    //                 <td style="text-align: center">
    //                     ' . $i . '
    //                 </td>
    //                 <td style="text-align: center">
    //                     ' . $cartItem['productname'] . '
    //                 </td>
    //                 <td style="text-align: center">
    //                     <img width="48" height="48" src="http://127.0.0.1:8000//Product/' . $cartItem->photo . '">
    //                 </td>
    //                 <td style="text-align: center">
    //                     ' . $attr->product_attribute_size . '
    //                 </td>
    //                 <td style="text-align: center">
    //                     ' . $cartItem['quantity'] . '
    //                 </td>
    //                 <td style="text-align: center">
    //                     ' . $cartItem['rate'] . '
    //                 </td>
    //                 <td style="text-align: center">
    //                     ' . $Total . '
    //                 </td>

    //             </tr>';
    //         $i++;
    //     }

    //     $templatePath = $root . '/mailers/checkoutmail.html';
    //     $htmlBody = @file_get_contents($templatePath);

    //     $address = trim(($order->shiiping_address1 ?? '') . ', ' . ($order->shiiping_address2 ?? ''), ', ');

    //     $awb_no = $order->docketNo ?? '';
    //     // dd($order);
    //     $replacements = [
    //         '#order_no'      => $id ?? '',
    //         '#name'      => $order->shipping_cutomerName ?? '',
    //         '#email'     => $order->shipping_email ?? '',
    //         '#mobile'    => $order->shipping_mobile ?? '',
    //         '#mobile1'   => $order->shipping_mobile1 ?? '',
    //         '#address'   => e($address),
    //         '#state'     => e($stateName),
    //         '#city'      => e($order->shipping_city ?? ''),
    //         '#pincode'   => e($order->shipping_pincode ?? ''),
    //         '#amount'    => number_format((float)$order->amount, 2),
    //         '#netAmount' => number_format((float)$order->netAmount, 2),
    //         '#tableProductTr' => $rowsHtml,

    //         '#awb_no' => $order->docketNo ?? '',
    //     ];
    //     $htmlBody = strtr($htmlBody, $replacements);
    //     // dd($htmlBody);

    //     // 6) Send emails (admin + customer) with Laravel Mail
    //     $subject = "Order Detail From Lolipop Kidswear Order No #{$id}";
    //     $fromMail = $sendEmail->strFromMail ?? config('mail.from.address');
    //     $fromName = $sendEmail->strFromName ?? config('mail.from.name');

    //     try {
    //         if ($adminEmail) {
    //             Mail::html($htmlBody, function ($m) use ($adminEmail, $subject, $fromMail, $fromName) {
    //                 $m->to($adminEmail)->subject($subject);
    //                 if ($fromMail) $m->from($fromMail, $fromName);
    //             });
    //         }

    //         if (!empty($order->shipping_email)) {
    //             Mail::html($htmlBody, function ($m) use ($order, $subject, $fromMail, $fromName) {
    //                 $m->to($order->shipping_email)->subject($subject);
    //                 if ($fromMail) $m->from($fromMail, $fromName);
    //             });
    //         }
    //     } catch (\Throwable $e) {
    //         Log::error('Checkout email send failed', ['order_id' => $id, 'err' => $e->getMessage()]);
    //         // continue; don’t block the thank-you page
    //     }

    //     $ORDER_ID = $id;
    //     $Customer = Customer::where("customerid", $order->customerid)->first();
    //     $InsertedId =  $Customer->customerid;
    //     $mobile = $order->shipping_mobile;
    //     $Setting = Setting::where(["id" => 1])->first();
    //     $key = $Setting->api_key;

    //     $textMessage = "Dear Customer, Your order will be dispatched within 3 working Days. Tracking Id will be soon issue to you. Regards, Team Lolipop Kidswear.";

    //         $cust = new Customer();
    //         $cust->sendMessage($mobile, $textMessage, "1707176528866290420");
    //         $cust->sendWhatsappMessage($mobile, $textMessage);

    //     $whatsappmsg = "Dear Customer, Your order will be dispatched within 3 working Days. Tracking Id will be soon issue to you. Regards, Team Lolipop Kidswear.";

    //         // $whatsappmsg = "*Dear {$order->shipping_cutomerName}*,\n\nYour Order No : $id.\n\nClick below to view your order:\nhttp://127.0.0.1:8000//Order/$ORDER_ID/{$Customer->guid}\n\nRegards,\nTeam WardrobeFashion.";

    //       $cust->WhatsappMessage($mobile, $whatsappmsg);

    //      // dd($whatsappmsg);
    //     // $customer = new Customer();
    //     // $message = "Dear Customer, Your order will be dispatched within 3 working Days. Tracking Id will be soon issue to you. Regards, Team Lolipop Kidswear.";
    //     // $status = $customer->sendWhatsappMessage($mobile, $message);
    //     // $status = $customer->sendMessage($mobile, $message,);


    //     return back()->with('success', 'Mail Send Successfully.');
    // }

    //     public function send_confirmation_message(Request $request, $id)
    //     {
    //             $order  = Order::where("order_id", $id)->first();

    //             $StateName = State::where(["stateId"=>$order->shiiping_state])->first();
    //             $stateName = $StateName->stateName ?? '';

    //             $sendEmail = DB::table('sendemaildetails')->where(['id' => 9])->first();
    //             $adminSetting = DB::table('setting')->select('email')->first();
    //             $adminEmail = $adminSetting->email ?? null;

    //              $root = $_SERVER['DOCUMENT_ROOT'];

    //             $OrderDetail = OrderDetail::select(
    //                 'orderdetail.orderDetailId',
    //                 'orderdetail.orderID',
    //                 'orderdetail.productId',
    //                 'orderdetail.created_at',
    //                 'orderdetail.quantity',
    //                 'orderdetail.rate',
    //                 'orderdetail.amount',
    //                 'orderdetail.size',
    //                 'product.productname',
    //                 DB::raw('(SELECT strphoto FROM productphotos WHERE  productphotos.productid=product.productId  LIMIT 1) as photo')
    //             )
    //                 ->where(['orderdetail.iStatus' => 1, 'orderdetail.isDelete' => 0, 'orderdetail.orderID' => $id])
    //                 ->join('product', 'orderdetail.productId', '=', 'product.productId')
    //                 ->get();

    //             $rowsHtml = '';
    //             $i = 1;
    //             foreach ($OrderDetail as $cartItem) {

    //                 $attr = ProductAttributes::orderBy('id', 'desc')
    //                     ->where(["product_id" => $cartItem->productId, 'id' => $cartItem->size])
    //                     ->first();

    //                 $Total = $cartItem['quantity'] * $cartItem['rate'];

    //                 $rowsHtml .= '
    //                 <tr>
    //                     <td style="text-align: center">
    //                         ' . $i . '
    //                     </td>
    //                     <td style="text-align: center">
    //                         ' . $cartItem['productname'] . '
    //                     </td>
    //                     <td style="text-align: center">
    //                         <img width="48" height="48" src="http://127.0.0.1:8000//Product/' . $cartItem->photo . '">
    //                     </td>
    //                     <td style="text-align: center">
    //                         ' . $attr->product_attribute_size . '
    //                     </td>
    //                     <td style="text-align: center">
    //                         ' . $cartItem['quantity'] . '
    //                     </td>
    //                     <td style="text-align: center">
    //                         ' . $cartItem['rate'] . '
    //                     </td>
    //                     <td style="text-align: center">
    //                         ' . $Total . '
    //                     </td>

    //                 </tr>';
    //                 $i++;
    //             }

    //             $templatePath = $root .'/mailers/checkoutmail.html';
    //             $htmlBody = @file_get_contents($templatePath);

    //             $address = trim(($order->shiiping_address1 ?? '').', '.($order->shiiping_address2 ?? ''), ', ');

    //             $replacements = [
    //                 '#order_no'      => $id ?? '',
    //                 '#name'      => $order->shipping_cutomerName ?? '',
    //                 '#email'     => $order->shipping_email ?? '',
    //                 '#mobile'    => $order->shipping_mobile ?? '',
    //                 '#mobile1'   => $order->shipping_mobile1 ?? '',
    //                 '#address'   => e($address),
    //                 '#state'     => e($stateName),
    //                 '#city'      => e($order->shipping_city ?? ''),
    //                 '#pincode'   => e($order->shipping_pincode ?? ''),
    //                 '#amount'    => number_format((float)$order->amount, 2),
    //                 '#netAmount' => number_format((float)$order->netAmount, 2),
    //                 '#tableProductTr' => $rowsHtml,
    //             ];
    //             $htmlBody = strtr($htmlBody, $replacements);

    //             // 6) Send emails (admin + customer) with Laravel Mail
    //             $subject = "Order Detail From Lolipop Kidswear Order No #{$id}";
    //             $fromMail = $sendEmail->strFromMail ?? config('mail.from.address');
    //             $fromName = $sendEmail->strFromName ?? config('mail.from.name');

    //              try {
    //                 if ($adminEmail) {
    //                     Mail::html($htmlBody, function ($m) use ($adminEmail, $subject, $fromMail, $fromName) {
    //                         $m->to($adminEmail)->subject($subject);
    //                         if ($fromMail) $m->from($fromMail, $fromName);
    //                     });
    //                 }

    //                 if (!empty($order->shipping_email)) {
    //                     Mail::html($htmlBody, function ($m) use ($order, $subject, $fromMail, $fromName) {
    //                         $m->to($order->shipping_email)->subject($subject);
    //                         if ($fromMail) $m->from($fromMail, $fromName);
    //                     });
    //                 }

    //             } catch (\Throwable $e) {
    //                 Log::error('Checkout email send failed', ['order_id' => $id, 'err' => $e->getMessage()]);
    //                 // continue; don’t block the thank-you page
    //             }

    //             $ORDER_ID = $id;
    //         $Customer = Customer::where("customerid", $order->customerid)->first();
    //         $InsertedId =  $Customer->customerid;
    //         $mobile = $order->shipping_mobile;
    //         $Setting = Setting::where(["id" => 1])->first();
    //         $key = $Setting->api_key;


    // $whatsappmsg = "*Dear $order->shipping_cutomerName*,\n\nYour Order No : $id.\n\nClick on the link below to see your order:\nhttp://127.0.0.1:8000//Order/$ORDER_ID/{$Customer->guid}\n\nRegards,\nTeam Wardrobefashion.";

    //         $message = "Dear Customer, Your order will be dispatched within 3 working Days. Tracking Id will be soon issue to you. Regards, Team Lolipop Kidswear.";

    //         // $customer = new Customer();
    //         // $status = $customer->sendWhatsappMessage($MobileNumber, $key, $msg, $InsertedId);

    //         $customer = new Customer();
    //         $status = $customer->sendWhatsappMessage($mobile, $message);


    //         $message = "Dear Customer, Your order will be dispatched within 3 working Days. Tracking Id will be soon issue to you. Regards, Team Lolipop Kidswear.";

    //         // $customer = new Customer();
    //         // $status = $customer->sendWhatsappMessage($MobileNumber, $key, $msg, $InsertedId);

    //         $customer = new Customer();
    //         $status = $customer->sendWhatsappMessage("9510081119", $message);

    //         //Whatsapp
    //         $whatsapp = $customer->WhatsappMessage($mobile, $whatsappmsg);


    //         return back()->with('success', 'Mail Send Successfully.');

    //     }

    public function order_collection(Request $request)
    {
        try {
            $FromDate = $request->fromdate;
            $ToDate = $request->todate;
            $OrderNo = $request->order_no;
            $CustomerName = $request->customer_name;
            $Mobile = $request->mobile;
            $datas = [];
            $collection = 0;
            $count = 0;

            // Get Courier list (if you still use in view)
            $Courier = Courier::orderBy('id', 'desc')
                ->where(['iStatus' => 1, 'isDelete' => 0])
                ->get();

            // Only run query when Search button clicked (when either date is entered)
            if (!empty($FromDate) && !empty($ToDate)) {

                // Convert to proper Carbon objects
                $from = Carbon::createFromFormat('d-m-Y', $FromDate)->startOfDay();
                $to = Carbon::createFromFormat('d-m-Y', $ToDate)->endOfDay();

                // Fetch orders within date range
                $datas = Order::select('order.*', 'courier.name as courier_name', 'courier.url')
                    ->leftJoin('courier', 'order.courier', '=', 'courier.id')
                    ->where(['order.iStatus' => 1, 'order.isDelete' => 0])
                    ->when($request->order_no, fn($query, $OrderNo) => $query
                        ->Where('order.order_id', '=', $OrderNo))
                    ->when($request->customer_name, fn($query, $CustomerName) => $query
                        ->where('order.shipping_cutomerName', 'like', '%' . $CustomerName . '%'))
                    ->when($request->mobile, fn($query, $Mobile) => $query
                        ->where('order.shipping_mobile', '=', $Mobile))
                    ->whereBetween('order.created_at', [$from, $to])
                    ->orderBy('order.order_id', 'DESC')
                    ->paginate(50);

                // Total collection for paid orders only
                $collection = Order::where(['iStatus' => 1, 'isDelete' => 0, 'order.isPayment' => 1])
                    ->whereBetween('created_at', [$from, $to])
                    ->sum('netAmount');

                $count = $datas->total();
            }

            return view('reports.order_collection', compact(
                'FromDate',
                'ToDate',
                'Courier',
                'datas',
                'count',
                'collection',
                'OrderNo',
                'CustomerName',
                'Mobile'
            ));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function total_sales(Request $request)
    {
        // dd($request);
        try {

            $years = Order::selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year')
                ->toArray();

            $states = State::orderBy('stateName', 'asc')->get();

            $selectedYear = $request->year ?? date('Y');
            $city = $request->city;
            $stateId = $request->state_id;
            $fromDate = $request->fromdate;
            $toDate = $request->todate;

            // Financial Year Apr → Mar
            $labels = ['Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'];
            $data = array_fill(0, 12, 0);

            // Base query
            $query = Order::where([
                'iStatus'   => 1,
                'isDelete'  => 0,
                'isPayment' => 1
            ]);

            // Financial year date range
            $financialStart = Carbon::create($selectedYear, 4, 1)->startOfDay();
            $financialEnd   = Carbon::create($selectedYear + 1, 3, 31)->endOfDay();

            $query->whereBetween('created_at', [$financialStart, $financialEnd]);

            // ⭐ State filter added (billing or shipping)
            if (!empty($stateId)) {
                $query->where(function ($q) use ($stateId) {
                    $q->where('state', $stateId)
                        ->orWhere('shiiping_state', $stateId);
                });
            }

            // City filter
            if (!empty($city)) {
                $query->where('city', 'LIKE', '%' . $city . '%');
            }

            if (!empty($fromDate)) {
                $from = Carbon::createFromFormat('d-m-Y', $fromDate)->startOfDay();
                $query->whereDate('created_at', '>=', $from);
            }

            if (!empty($toDate)) {
                $to = Carbon::createFromFormat('d-m-Y', $toDate)->endOfDay();
                $query->whereDate('created_at', '<=', $to);
            }

            // Monthly results (Apr → Mar)
            $sales = $query
                ->selectRaw('MONTH(created_at) as month, SUM(netAmount) as total_amount')
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            // Map results to financial year month indexes
            foreach ($sales as $row) {

                $month = (int)$row->month;

                if ($month >= 4) {
                    $index = $month - 4;  // Apr→0
                } else {
                    $index = $month + 8;  // Jan→9
                }

                $data[$index] = (float) $row->total_amount;
            }

            $yearTotal = array_sum($data);

            return view('reports.total_sales', compact(
                'years',
                'states',
                'selectedYear',
                'city',
                'stateId',
                'fromDate',
                'toDate',
                'labels',
                'data',
                'yearTotal'
            ));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
