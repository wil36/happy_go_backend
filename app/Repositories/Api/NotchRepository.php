<?php

namespace App\Repositories\Api;

use Illuminate\Support\Facades\Http;


class NotchRepository
{

    private $token;

    public function __construct()
    {
        $this->token = env("NOTCH_TOKEN_PRODUCTION");
    }

    // Initialisation d'une transaction
    public function initTransac($params)
    {


        // Contruction de URL avec les paramètres
        $url = "https://api.notchpay.co/payments/initialize?" . http_build_query($params);

        $response = Http::withHeaders([
            'Authorization' => $this->token,
            'Accept' => 'application/json',
        ])->retry(3, 300)->post($url);

        if ($response->successful()) {
            // La requête a réussi
            return $response->json();
        }

        if ($response->failed()) {
            // La requête a échoué
            return $response->json();
        }
    }


    // Requete HTTP de confirmation de paiement
    public function confirmTransacRequest($channel, $data, $ref)
    {

        // return $data;

        $response = Http::withHeaders([
            'Authorization' => $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->withBody(json_encode([
            'channel' => $channel,
            'data' => $data

        ]), 'application/json')->put('https://api.notchpay.co/payments/' . $ref);

        if ($response->successful()) {
            // La requête a réussi
            return $response->json();
        }

        if ($response->failed()) {
            // La requête a échoué
            return $response->json();
        }
    }

    // Annulation d'une transaction
    public function cancelTransRequest($ref)
    {

        $response = Http::withHeaders([
            'Authorization' => $this->token,
            'Accept' => 'application/json',
        ])->delete('https://api.notchpay.co/payments/' . $ref);

        if ($response->successful()) {
            // La requête a réussi
            return $response->json();
        }

        if ($response->failed()) {
            // La requête a échoué
            return $response->json();
        }
    }
}