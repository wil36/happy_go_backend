<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FirebaseController extends Controller
{


    function getChauffeurNonValider(Request $request)
    {
        return view('pages.chauffeur_nonvalide');
    }

    function getChauffeurValider()
    {
        return view('pages.chauffeur_valide');
    }

    function sendFcm(Request $request)
    {
        $SERVER_API_KEY = 'AAAAIQWc1zM:APA91bFhuinSCm7dwr_NQ1mo03gfeTlDDCqy2zt8DodL_Y0WdeoRRwdkDWfoJf4iCiN-xT_S-EahLSc_as-b5FZIsMZ8UzdYQucJx5tg4YtYxpGWhc3D_GZ_9_50SPv8j2spfAZSzTzq';
        $data = [
            "registration_ids" => [
                $request->token_user,
            ],
            "notification" => [

                "title" => $request->title,

                "body" => $request->body,
                'type' => $request->type,

                "sound" => "default" // required for sound on ios

            ],

        ];

        $dataString = json_encode($data);

        $headers = [

            'Authorization: key=' . $SERVER_API_KEY,

            'Content-Type: application/json',

        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
    }
}