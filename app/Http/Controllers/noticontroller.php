<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class noticontroller extends Controller
{

    function show(){
        return view('noti');
    }
    function send(){
        // $token = "c4jaUacB5fA:APA91bHgqSRxs4k5ouWDGdCZ63S2-EaCQfqpE2w_gWPyuJNTvMLgrG0LBC7hAENXhPa8q5lVZH1utZ2Kl37-SVnmpgp82_eHdAB00uma5gr0Wk8r62Rd8BSRXCn4wHo5vsi5BfUMyQYQ";  
        $token = "d1VC8jmZRL-4maUWM2che4:APA91bFQMZHwu38Tn-0kHMVAoCF0do1Uh2DB-dOSolvHU7977XWVmXCZ1zBiTyLekyHcCnXQMbrev9QYg6PBGQnLSDEd2xhOjpJomeEMn_nFJgZH0jv5Lh3LuIDm6W0PVe7FnNc6uSkR";  
        $from = "AAAA53N59_0:APA91bF27-YuWlYtfLoFYPDzsTqzL7VZvkTD5VsU3Gz9kh2thHQrn0HLm3lG4oedlPBNsqR61th11zgCkb_zHuJwm96oZzm0UBkHItKKgkcYF5YvawN32URY2lZTLMg8GcYMmccdDJC8";
        $msg = array
              (
                'body'  => "Testing Testing",
                'title' => "Hi, From Wecan",
                'receiver' => 'Alaa',
                
                //'icon'  => "https://wecan.jo/wp-content/uploads/2020/06/logowecan.jpg",/*Default Icon*/
                'sound' => 'mySound'/*Default sound*/
              );

        $fields = array
                (
                    'to'        => $token,
                    'notification'  => $msg
                    
                );
                

        $headers = array
                (
                    'Authorization: key=' . $from,
                    'Content-Type: application/json'
                );
        //#Send Reponse To FireBase Server 
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        dd($result);
        curl_close( $ch );
    }

    function send2( Request $request ){
        $FcmToken = User::whereNotNull('token')->pluck('token')->all();
        // $token = "c4jaUacB5fA:APA91bHgqSRxs4k5ouWDGdCZ63S2-EaCQfqpE2w_gWPyuJNTvMLgrG0LBC7hAENXhPa8q5lVZH1utZ2Kl37-SVnmpgp82_eHdAB00uma5gr0Wk8r62Rd8BSRXCn4wHo5vsi5BfUMyQYQ";  
        $token = "d1VC8jmZRL-4maUWM2che4:APA91bFQMZHwu38Tn-0kHMVAoCF0do1Uh2DB-dOSolvHU7977XWVmXCZ1zBiTyLekyHcCnXQMbrev9QYg6PBGQnLSDEd2xhOjpJomeEMn_nFJgZH0jv5Lh3LuIDm6W0PVe7FnNc6uSkR";  
        $from = "AAAA53N59_0:APA91bF27-YuWlYtfLoFYPDzsTqzL7VZvkTD5VsU3Gz9kh2thHQrn0HLm3lG4oedlPBNsqR61th11zgCkb_zHuJwm96oZzm0UBkHItKKgkcYF5YvawN32URY2lZTLMg8GcYMmccdDJC8";
        $msg = array
              (
                'body'  => $request->content,
                'title' => $request->title,
                'receiver' => 'Alaa',
                
                //'icon'  => "https://wecan.jo/wp-content/uploads/2020/06/logowecan.jpg",/*Default Icon*/
                'sound' => 'mySound'/*Default sound*/
              );

        $fields = array
                (
                    "registration_ids" => $FcmToken,
                    'notification'  => $msg
                    
                );
                

        $headers = array
                (
                    'Authorization: key=' . $from,
                    'Content-Type: application/json'
                );
        //#Send Reponse To FireBase Server 
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
       // dd($FcmToken);
        curl_close( $ch );

        return redirect()->back();
    }
}
