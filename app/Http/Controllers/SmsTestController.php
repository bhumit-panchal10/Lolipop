<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class SmsTestController extends Controller
{
    public function send()
    {
        //$MobileNumber = "9824773136";
        $MobileNumber = "9824613136";
        $docketNo = "1234567890";

        $url = "https://web.shreesms.net/API/SendSMS.aspx?APIkey=JlKI05wegcsbGlBMKV2F5SfoeW&SenderID=TWFASH&SMSType=2&Mobile=" . $MobileNumber . "&MsgText=Dear Customer, Click on the link below to track your order : http://www.shreetirupaticourier.net Awb No : " . $docketNo . " Regards, Team The Wardrobe.&EntityID=1701172008749013160&TemplateID=1707176442606014415";
        //$url = "https://web.shreesms.net/API/SendSMS.aspx?APIkey=JlKI05wegcsbGlBMKV2F5SfoeW&SenderID=TWFASH&SMSType=2&Mobile=".$MobileNumber."&MsgText=Dear Customer, Click on the link below to track your order: https://www.delhivery.com/track/package/".$docketNo." Regards, Team Lolipop Kidswear.&EntityID=1701172008749013160&TemplateID=1707172128729766008";

        // Send request
        $response = Http::withoutVerifying()->get($url);

        return [
            "url_called" => $url,
            "status_code" => $response->status(),
            "response" => $response->body()
        ];
    }
}
