<?php

namespace App\Repositories\Api;

use Illuminate\Support\Facades\Http;


class NotchRepository
{

    private $token;
    private $privateToken;

    public function __construct()
    {
        $this->token = env("NOTCH_TOKEN_PRODUCTION");
        $this->privateToken = env("NOTCH_TOKEN_PRIVATE_PRODUCTION");
    }

    // Initialisation d'une transaction
    public function initTransac($params)
    {
        // Contruction de URL avec les paramètres
        $url = "https://api.notchpay.co/payments/initialize?" . http_build_query($params);

        $response = Http::withHeaders([
            'Authorization' => $this->token,
            "X-Grant" => $this->privateToken,
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

    public function initTransferts($params)
    {
        // Contruction de URL avec les paramètres
        $url = "https://api.notchpay.co/transfers?" . http_build_query($params);

        $response = Http::withHeaders([
            "X-Grant" => $this->privateToken,
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


    public function verifyTransferts($ref)
    {
        // Contruction de URL avec les paramètres
        $url = "https://api.notchpay.co/transfers/" . $ref;

        $response = Http::withHeaders([
            "X-Grant" => $this->privateToken,
            'Authorization' => $this->token,
            'Accept' => 'application/json',
        ])->retry(3, 300)->get($url);

        if ($response->successful()) {
            // La requête a réussi
            return $response->json();
        }

        if ($response->failed()) {
            // La requête a échoué
            return $response->json();
        }
    }

    // Requete HTTP de confirmation de transfert
    public function confirmTransfert($ref)
    {

        $response = Http::withHeaders([
            'Authorization' => $this->token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->withBody(json_encode([]), 'application/json')->put('https://api.notchpay.co/transfers/' . $ref);

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

    // Annulation d'une transaction
    public function createRecipient($params)
    {
        $url = "https://api.notchpay.co/recipients?" . http_build_query($params);

        $response = Http::withHeaders([
            'Authorization' => $this->token,
            "X-Grant" => $this->privateToken,
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

    public function getRecipient()
    {
        $url = "https://api.notchpay.co/recipients/rcp.FY6J0IYH2awGskGN2";

        $response = Http::withHeaders([
            'Authorization' => $this->token,
            "X-Grant" => $this->privateToken,
            'Accept' => 'application/json',
        ])->retry(3, 300)->get($url);
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