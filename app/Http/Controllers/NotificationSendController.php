<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationSendController extends Controller
{
    public function updateDeviceToken(Request $request)
    {
        Auth::user()->device_token = $request->token;

        Auth::user()->save();

        return response()->json(['Token successfully stored.']);
    }



    public function sendNotification(Request $request)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $FcmToken = User::whereNotNull('device_token')->pluck('device_token')->all();

        $serverKey = 'AAAAT6LfogQ:APA91bGGuo1eoQPJIsZb9uyCjKXnbUQ_cl5XZuInCMmTt-gyL5nUjyErwjpToXZehKoY5bI0gpMd1j7L_qe2mbpAAUDV5rdW58LyQ8IUKnCg6Mlquftym6n3ogcYogcc9KUobxwcMAHd'; // ADD SERVER KEY HERE PROVIDED BY FCM'; // ADD SERVER KEY HERE PROVIDED BY FCM

        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
            ]
        ];
        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        // FCM response
        //dd($result);
        // Log::info('FCM response: ' . $result);
    }


    // protected function sendNotification()
    // {
    //     $url = 'https://fcm.googleapis.com/fcm/send';

    //     $adminTokens = User::where('role', 'admin')->whereNotNull('device_token')->pluck('device_token')->all();

    //     $serverKey = 'AAAAT6LfogQ:APA91bGGuo1eoQPJIsZb9uyCjKXnbUQ_cl5XZuInCMmTt-gyL5nUjyErwjpToXZehKoY5bI0gpMd1j7L_qe2mbpAAUDV5rdW58LyQ8IUKnCg6Mlquftym6n3ogcYogcc9KUobxwcMAHd'; // ADD SERVER KEY HERE PROVIDED BY FCM'; // ADD SERVER KEY HERE PROVIDED BY FCM
    //     $data = [
    //         "registration_ids" => $adminTokens,
    //         "notification" => [
    //             "title" => "New Purchase Request",
    //             "body" => "A wholesaler has requested to purchase products."
    //         ]
    //     ];

    //     $encodedData = json_encode($data);

    //     $headers = [
    //         'Authorization: key=' . $serverKey,
    //         'Content-Type: application/json',
    //     ];

    //     $ch = curl_init();

    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

    //     $result = curl_exec($ch);
    //     if ($result === FALSE) {
    //         die('Curl failed: ' . curl_error($ch));
    //     }

    //     curl_close($ch);

    //     // Optionally, log the response for debugging
    //     Log::info('FCM response: ' . $result);
    // }


}
