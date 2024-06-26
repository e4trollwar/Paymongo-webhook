<?php

namespace App\Http\Controllers;

use App\Models\webhookModel;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    //

    public function __construct(){ 
        $this->webhookModel = New webhookModel();

    }

    public function checkout(Request $request){


        $total =$request->total;
        //$quantity =$request->quantity;
        $description =$request->description;

        $curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => "https://api.paymongo.com/v1/links",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode([
            'data' => [
                'attributes' => [
                        'amount' => $total*100,
                        'description' => $description,
                        'remarks' => 'to pay'
                ]
            ]
          ]),
          CURLOPT_HTTPHEADER => [
            "accept: application/json",
            "authorization: Basic c2tfdGVzdF9NcFBjSEpNRUFSRXY4U0VIQ05tY2MxcUc6",
            "content-type: application/json"
          ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        //get the checkout URL response from $response/curl response
        //we need to decode the curl response
        $decodedResponse = json_decode($response, true);
        curl_close($curl);

            foreach ($decodedResponse as $key => $value) {
                    //we got this from json response, this is the checkout URL
                    $checkout_url = $decodedResponse[$key]['attributes']['checkout_url'];

                    //next, our page must be redirect on the checkout URL
                    return redirect()->to($checkout_url);
            }
        

    }

    public function notify(){
        $result= webhookModel::count();

       
        header('Content-type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');
        if($result >= 1){
            echo "data: " . json_encode($result) . "\n\n";
        }else{
            echo "data: " . "\n\n";
        }
        
        ob_flush();
        flush();
        
    }


    public function webhook(Request $request){
        $webhook_secret = env('Webhook_Secret');
        $webhook_signature = $request->header('Paymongo_Signature');
        $event_datas = $request->getContent();
        $event_filter = json_decode($event_datas,true);
        
        


        //split header_signature response into 2 parts the response from header is t=xxxxxx,te=xxxxxx,li=xxxxxx
        $webhook_signature_raw = preg_split("/,/",$webhook_signature);
        $webhook_signature_raw_time = preg_split("/=/",$webhook_signature_raw[0]);
        $webhook_signature_raw_data = preg_split("/=/",$webhook_signature_raw[1]);

        //final result
        $webhook_signature_time = $webhook_signature_raw_time[1];
        $webhook_signature_data = $webhook_signature_raw_data[1];

        //concatinate the time that we get from webhook_signature response ex: 17169545524{$event_datas}
        $webhook_time_with_json_data = $webhook_signature_time.'.'.$event_datas;

        $computedSignature =hash_hmac('sha256', $webhook_time_with_json_data,$webhook_secret );

        //compare the te=xxxxx value with $computedSignature if same
        $mySignature = hash_equals($computedSignature,$webhook_signature_data);

       

        if($mySignature == 1 || $mySignature == true){
            
           foreach($event_filter as $datas){
            webhookModel::insert([
            'payload'=>$datas['attributes']['type'],
            ]);
        }
        }else{
            webhookModel::insert([
            'payload'=>'invalid',
            ]);
        }
        
        



    }

}

