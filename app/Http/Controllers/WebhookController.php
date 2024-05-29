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
        $quantity =$request->quantity;
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
        $decodedResponse = json_decode($response, true);
        curl_close($curl);

                foreach ($decodedResponse as $key => $value) {
           $checkout_url = $decodedResponse[$key]['attributes']['checkout_url'];

           return redirect()->to($checkout_url);
        }
        

    }

    public function success(){

    }


    public function webhook(Request $request){
        $webhook_secret = env('Webhook_Secret');
        $webhook_signature = $request->header('Paymongo-Signature');

        webhookModel::test([
            'payload'=$webhook_signature,
        ])



    }

}
