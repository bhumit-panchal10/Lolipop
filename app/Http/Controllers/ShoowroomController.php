<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Courier;
use App\Models\Customer;

class ShoowroomController extends Controller
{
    /**
     * Show listing page
     */
    public function index(Request $request)
    {
        $couriers = DB::table('courier')
        ->where('iStatus', 1)
        ->where('isDelete', 0)
        ->orderBy('name')
        ->get();
        
        $query = DB::table('shoowroomreports as sr')
            ->leftJoin('courier as c', 'c.id', '=', 'sr.courier_id')
            ->select(
                'sr.*',
                'c.name as courier_name',
                'c.url as courier_url'
            );

        // Filters
        if ($request->name) {
            $query->where('sr.customer_name', 'like', "%{$request->name}%");
        }

        if ($request->mobile) {
            $query->where('sr.mobile', 'like', "%{$request->mobile}%");
        }

        if ($request->email) {
            $query->where('sr.email', 'like', "%{$request->email}%");
        }

        $ShowroomOrders = $query
            ->orderBy('sr.id', 'DESC')
            ->paginate(20);

        return view('showroom.index', compact('ShowroomOrders','couriers'))
            ->with('name', $request->name)
            ->with('mobile', $request->mobile)
            ->with('email', $request->email);
    }



    /**
     * Show Add Page
     */
    public function create()
    {
        // Fetch all couriers for dropdown
        $couriers = DB::table('courier')->orderBy('name')->get();

        return view('showroom.add', compact('couriers'));
    }

    /**
     * Store new record
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'mobile'        => 'required|string|max:20',
            'courier_id'    => 'required|exists:courier,id',
            'docketNo'      => 'required|string|max:255',
        ]);
        // dd($request);

        /* -----------------------------
        1. Fetch Courier
        ----------------------------- */
        $courier = Courier::where([
            'id' => $request->courier_id,
            'iStatus' => 1,
            'isDelete' => 0,
        ])->first();

        if (!$courier) {
            return back()->with('error', 'Invalid courier selected.');
        }

        /* -----------------------------
        2. Tracking URL + Docket Type
        ----------------------------- */
        $trackingUrl = '';
        $docketType  = 'Docket No';

        if ($courier->id == 1) {
            $trackingUrl = $courier->url;
            $docketType  = 'AWB No';
        } elseif ($courier->id == 2) {
            $trackingUrl = $courier->url . $request->docketNo;
            $docketType  = 'Docket No';
        } else {
            $trackingUrl = $courier->url;
            $docketType  = 'Article No';
        }

        /* -----------------------------
        3. Insert Showroom Entry
        ----------------------------- */
        DB::table('shoowroomreports')->insert([
            'customer_name' => $request->customer_name,
            'mobile'        => $request->mobile,
            'email'         => $request->email,
            'courier_id'    => $request->courier_id,
            'docketNo'      => $request->docketNo,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);


        /* -----------------------------
        4. Send Email (HTML Template)
        ----------------------------- */
        if (!empty($request->email)) {

            $sendEmail = DB::table('sendemaildetails')->where('id', 10)->first();
            $subject   = $sendEmail->strSubject ?? 'Dispatch Details';

            $root = $_SERVER['DOCUMENT_ROOT'];
            $htmlBody = file_get_contents($root . '/mailers/dispatchemail.html');

            $htmlBody = str_replace(
                ['#orderNo', '#courierName', '#docketNo', '#link', '#docketType'],
                ['-', $courier->name, $request->docketNo, $trackingUrl, $docketType],
                $htmlBody
            );
            

            try {
                Mail::html($htmlBody, function ($m) use ($request, $subject, $sendEmail) {
                    $m->to($request->email)
                        ->subject($subject);

                    if (!empty($sendEmail->strFromMail)) {
                        $m->from(
                            $sendEmail->strFromMail,
                            $sendEmail->strFromName ?? config('app.name')
                        );
                    }
                });
            } catch (\Throwable $e) {
                Log::error('Showroom dispatch email failed', ['err' => $e->getMessage()]);
            }
        }
        // dd($htmlBody);

        /* -----------------------------
        5. WhatsApp Message
        ----------------------------- */
        $customer = new Customer();

        if ($courier->id == 1) {
            $whatsappMsg =
                "*Dear {$request->customer_name}*,\n\n" .
                "Your parcel has been dispatched.\n\n" .
                "Tracking Link:\n{$trackingUrl}\n\n" .
                "Your {$docketType}: *{$request->docketNo}*\n\n" .
                "Regards,\nTeam The Wardrobe Fashion.";
        } else {
            $whatsappMsg =
                "*Dear {$request->customer_name}*,\n\n" .
                "Click on the below link to track your order:\n" .
                "{$trackingUrl}\n\n" .
                "Regards,\nTeam The Wardrobe Fashion.";
        }

        $customer->WhatsappMessage($request->mobile, $whatsappMsg);

        /* -----------------------------
        6. SMS (Courier Based)
        ----------------------------- */
        if ($courier->id == 1) {
            $customer->tirupatiMsg($request->mobile, $request->docketNo);
        } elseif ($courier->id == 2) {
            $customer->delhiveryMsg($request->mobile, $request->docketNo);
        } else {
            $customer->indianpostMsg($request->mobile, $request->docketNo);
        }

        return redirect()
            ->route('shoowroom.index')
            ->with('success', 'Entry added & SMS  / Email sent successfully.');
    }

    public function resend($id)
    {
        // 1. Fetch showroom record
        $order = DB::table('shoowroomreports')->where('id', $id)->first();

        if (!$order) {
            return back()->with('error', 'Record not found.');
        }
        // dd($order);

        // 2. Fetch courier
        $courier = Courier::where([
            'id' => $order->courier_id,
            'iStatus' => 1,
            'isDelete' => 0
        ])->first();

        if (!$courier) {
            return back()->with('error', 'Courier not found.');
        }

        // 3. Tracking URL + Docket Type
        $trackingUrl = '';
        $docketType  = 'Docket No';

        if ($courier->id == 1) {
            $trackingUrl = $courier->url;
            $docketType  = 'AWB No';
        } elseif ($courier->id == 2) {
            $trackingUrl = $courier->url . $order->docketNo;
        } else {
            $trackingUrl = $courier->url;
            $docketType  = 'Article No';
        }

        /* -----------------------------
       4. EMAIL
    ----------------------------- */
        if (!empty($order->email)) {

            $sendEmail = DB::table('sendemaildetails')->where('id', 10)->first();
            $subject   = $sendEmail->strSubject ?? 'Dispatch Details';

            $root = $_SERVER['DOCUMENT_ROOT'];
            $htmlBody = file_get_contents($root . '/mailers/dispatchemail.html');

            $htmlBody = str_replace(
                ['#orderNo', '#courierName', '#docketNo', '#link', '#docketType'],
                ['-', $courier->name, $order->docketNo, $trackingUrl, $docketType],
                $htmlBody
            );
            // dd($htmlBody);

            try {
                Mail::html($htmlBody, function ($m) use ($order, $subject, $sendEmail) {
                    $m->to($order->email)->subject($subject);

                    if (!empty($sendEmail->strFromMail)) {
                        $m->from(
                            $sendEmail->strFromMail,
                            $sendEmail->strFromName ?? config('app.name')
                        );
                    }
                });
            } catch (\Throwable $e) {
                Log::error('Showroom resend email failed', ['err' => $e->getMessage()]);
            }
        }

        /* -----------------------------
       5. WHATSAPP
    ----------------------------- */
        $customer = new Customer();

        if ($courier->id == 1) {
            $whatsappMsg =
                "*Dear {$order->customer_name}*,\n\n" .
                "Your parcel has been dispatched.\n\n" .
                "Tracking Link:\n{$trackingUrl}\n\n" .
                "{$docketType}: *{$order->docketNo}*\n\n" .
                "Regards,\nTeam The Wardrobe Fashion.";
        } else {
            $whatsappMsg =
                "*Dear {$order->customer_name}*,\n\n" .
                "Click on the below link to track your order:\n" .
                "{$trackingUrl}\n\n" .
                "Regards,\nTeam The Wardrobe Fashion.";
        }

        $customer->WhatsappMessage($order->mobile, $whatsappMsg);

        /* -----------------------------
       6. SMS
    ----------------------------- */
        if ($courier->id == 1) {
            $customer->tirupatiMsg($order->mobile, $order->docketNo);
        } elseif ($courier->id == 2) {
            $customer->delhiveryMsg($order->mobile, $order->docketNo);
        } else {
            $customer->indianpostMsg($order->mobile, $order->docketNo);
        }

        return back()->with('success', 'SMS, WhatsApp & Email resent successfully.');
    }
    
    public function edit($id)
    {
        $order = DB::table('shoowroomreports')->where('id', $id)->first();

        if (!$order) {
            return response()->json(['error' => 'Not found'], 404);
        }

        return response()->json($order);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'required',
            'mobile'        => 'required',
            'courier_id'    => 'required|exists:courier,id',
            'docketNo'      => 'required',
        ]);

        DB::table('shoowroomreports')->where('id', $id)->update([
            'customer_name' => $request->customer_name,
            'mobile'        => $request->mobile,
            'email'         => $request->email,
            'courier_id'    => $request->courier_id,
            'docketNo'      => $request->docketNo,
            'updated_at'    => now(),
        ]);

        return back()->with('success', 'Showroom order updated successfully.');
    }

    public function destroy($id)
    {
        $order = DB::table('shoowroomreports')->where('id', $id)->first();

        if (!$order) {
            return back()->with('error', 'Record not found.');
        }

        DB::table('shoowroomreports')->where('id', $id)->delete();

        return back()->with('success', 'Showroom order deleted successfully.');
    }
}
