<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Setting;

class Customer extends Model
{
    use HasFactory;
    public $table = 'customer';
    protected $fillable = [
        'customername',
        'password',
        'customermobile',
        'customeremail',
        'strIP',
        'token',
    ];

    // public function sendWhatsappMessage($mobile, $msgText)
    // {
    //     $client = new Client();
    //     $apiKey = 'JlKI05wegcsbGlBMKV2F5SfoeW';
    //     $senderID = 'TWFASH';
    //     $smsType = '2';
    //     $entityID = '1701172008749013160';
    //     $templateID = '1707172104144059732';

    //     $url = "https://web.shreesms.net/API/SendSMS.aspx";
    //     $params = [
    //         'APIkey' => $apiKey,
    //         'SenderID' => $senderID,
    //         'SMSType' => $smsType,
    //         'Mobile' => $mobile,
    //         'MsgText' => $msgText,
    //         'EntityID' => $entityID,
    //         'TemplateID' => $templateID,
    //     ];

    //     try {
    //         $response = $client->request('GET', $url, ['query' => $params]);
    //         return $response->getBody()->getContents();
    //     } catch (RequestException $e) {
    //         // Handle error
    //         return $e->getMessage();
    //     }
    // }

    // public function tirupatiMsg($MobileNumber, $docketNo)
    // {
    //     //$message = "https://web.shreesms.net/API/SendSMS.aspx?APIkey=JlKI05wegcsbGlBMKV2F5SfoeW&SenderID=TWFASH&SMSType=2&Mobile=".$MobileNumber."&MsgText=Dear Customer, Click on the link below to track your order: http://www.shreetirupaticourier.net/Frm_DocTrack.aspx?docno=".$docketNo." Regards , Team The Wardrobe&EntityID=1701172008749013160&TemplateID=1707172104144059732";
    //     //$message = "https://web.shreesms.net/API/SendSMS.aspx?APIkey=JlKI05wegcsbGlBMKV2F5SfoeW&SenderID=TWFASH&SMSType=2&Mobile=".$MobileNumber."&MsgText=Dear Customer, Click on the link below to track your order: http://www.shreetirupaticourier.net/Frm_DocTrack.aspx?docno=".$docketNo." Regards, Team The Wardrobe.&EntityID=1701172008749013160&TemplateID=1707172104144059732";

    //     /**New**/
    //     $message = "https://web.shreesms.net/API/SendSMS.aspx?APIkey=JlKI05wegcsbGlBMKV2F5SfoeW&SenderID=TWFASH&SMSType=2&Mobile=".$MobileNumber."&MsgText=Dear Customer, Click on the link below to track your order : http://www.shreetirupaticourier.net Awb No : ".$docketNo." Regards, Team The Wardrobe.&EntityID=1701172008749013160&TemplateID=1707176442606014415";
    //     return $this->sendMessage1($message);
    //     //return true;
    // }

    // public function delhiveryMsg($MobileNumber, $docketNo)
    // {
    //     //$message = "https://web.shreesms.net/API/SendSMS.aspx?APIkey=JlKI05wegcsbGlBMKV2F5SfoeW&SenderID=TWFASH&SMSType=2&Mobile=".$MobileNumber."&MsgText=Dear Customer, Click on the link below to track your order: http://www.delhivery.com/track/package/".$docketNo." Regards , Team The Wardrobe Fashion&EntityID=1701172008749013160&TemplateID=1707172128729766008";
    //     //$message = "https://web.shreesms.net/API/SendSMS.aspx?APIkey=JlKI05wegcsbGlBMKV2F5SfoeW&SenderID=TWFASH&SMSType=2&Mobile=".$MobileNumber."&MsgText=Dear Customer, Click on the link below to track your order: https://www.delhivery.com/track/package/".$docketNo." Regards, Team The Wardrobe Fashion.&EntityID=1701172008749013160&TemplateID=1707172128729766008";

    //     /**New**/
    //     $message = "https://web.shreesms.net/API/SendSMS.aspx?APIkey=JlKI05wegcsbGlBMKV2F5SfoeW&SenderID=TWFASH&SMSType=2&Mobile=".$MobileNumber."&MsgText=Dear Customer, Click on the link below to track your order: https://www.delhivery.com/track/package/".$docketNo." Regards, Team The Wardrobe Fashion.&EntityID=1701172008749013160&TemplateID=1707172128729766008";
    //     return $this->sendMessage1($message);
    //     //return true;
    // }

    // public function indianpostMsg($MobileNumber, $docketNo)
    // {

    //     /**New**/
    //     //$message = "https://web.shreesms.net/API/SendSMS.aspx?APIkey=JlKI05wegcsbGlBMKV2F5SfoeW&SenderID=TWFASH&SMSType=2&Mobile=".$MobileNumber."&MsgText=Dear Customer, Click on the link below to track your order : www.indiapost.gov.in Article No : ".$docketNo." Regards, Team The Wardrobe.&EntityID=1701172008749013160&TemplateID=1707176545360095516";
    //     $message = "https://web.shreesms.net/API/SendSMS.aspx?APIkey=JlKI05wegcsbGlBMKV2F5SfoeW&SenderID=TWFASH&SMSType=2&Mobile=".$MobileNumber."&MsgText=Dear Customer, Click on the link below to track your order : www.indiapost.gov.in Article No : ".$docketNo." Regards, Team The Wardrobe Fashion.&EntityID=1701172008749013160&TemplateID=1707176545360095516";
    //     return $this->sendMessage1($message);
    //     //return true;
    // }

    //  public function ShreemahavirMsg($MobileNumber, $docketNo)
    // {
    //     $message = "https://web.shreesms.net/API/SendSMS.aspx?APIkey=JlKI05wegcsbGlBMKV2F5SfoeW&SenderID=TWFASH&SMSType=2&Mobile=".$MobileNumber."&MsgText=Dear Customer, Click on the link below to track your order : https://shreemahavircourier.in/ consignment No : ".$docketNo." Regards, Team The Wardrobe Fashion.&EntityID=1701172008749013160&TemplateID=1707176545360095516";
    //     return $this->sendMessage1($message);
    // }



    // public function sendMessage($mobile, $msgText, $templateID)
    // {
    //     $client = new Client();
    //     $apiKey = 'JlKI05wegcsbGlBMKV2F5SfoeW';
    //     $senderID = 'TWFASH';
    //     $smsType = '2';
    //     $entityID = '1701172008749013160';

    //     $url = "https://web.shreesms.net/API/SendSMS.aspx";
    //     $params = [
    //         'APIkey' => $apiKey,
    //         'SenderID' => $senderID,
    //         'SMSType' => $smsType,
    //         'Mobile' => $mobile,
    //         'MsgText' => $msgText,
    //         'EntityID' => $entityID,
    //         'TemplateID' => $templateID,
    //     ];

    //     try {
    //         $response = $client->request('GET', $url, ['query' => $params]);
    //         $responseBody = $response->getBody()->getContents();

    //         return $responseBody;
    //     } catch (RequestException $e) {
    //         // Handle error
    //         Log::error("Failed to send SMS to {$mobile}: " . $e->getMessage());
    //         return $e->getMessage();
    //     }
    // }

    // private function sendMessage1($msgText)
    // {
    //     $client = new Client();
    //     try {
    //         $response = $client->request('GET', $msgText);
    //         $responseBody = $response->getBody()->getContents();

    //         return $responseBody;
    //     } catch (RequestException $e) {
    //         // Handle error
    //         // Log::error("Failed to send SMS to {$mobile}: " . $e->getMessage());
    //         return $e->getMessage();
    //     }
    // }
}
