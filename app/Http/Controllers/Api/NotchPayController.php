<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Repositories\Api\NotchRepository;

class NotchPayController extends Controller
{

    private $token;
    private $nocthRepository;


    public function __construct(NotchRepository $nocthRepository)
    {
        $this->token = env("NOTCH_TOKEN_PRODUCTION");
        // $this->token = env("NOTCH_TOKEN_SANDBOX");
        $this->nocthRepository = $nocthRepository;
    }



    // Tester la clé d'API NotchPay
    public function testApiKey()
    {

        $response = Http::withHeaders([
            'Authorization' => $this->token,
        ])->get('https://api.notchpay.co');

        if ($response->successful()) {
            // La requête a réussi
            dd($response->body());
        }

        if ($response->failed()) {
            // La requête a échoué
            dd($response->body());
        }
    }

    // Initialisation transaction pack mois Euroupe
    public function initTransac(Request $request)
    {


        // Création de URL avec les paramètres en GET de la transaction
        $params = [
            'email' => $request->email,
            'name' => "Mobile User",
            'currency' => $request->currency,
            'amount' => $request->amount,
            'phone' => $request->phone,
            'description' => 'HappyGo',
        ];

        // Requete vers NotchPay pour l'initiation de la transaction
        $transaction = $this->nocthRepository->initTransac($params);

        return $transaction;
    }

    // Initialisation transaction pack mois Euroupe
    public function initTransferts(Request $request)
    {
        // Création de URL avec les paramètres en GET de la transaction
        $params = [
            'currency' => $request->currency,
            'amount' => $request->amount,
            'recipient' => $request->recipient,
            'description' => $request->description,
        ];

        // Requete vers NotchPay pour l'initiation de la transaction
        $transaction = $this->nocthRepository->initTransferts($params);

        return $transaction;
    }

    public function verifyTransferts(Request $request)
    {
        // Requete vers NotchPay pour l'initiation de la transaction
        $transaction = $this->nocthRepository->verifyTransferts($request->ref);

        return $transaction;
    }


    // Vérification de l'etat d'une transaction
    public function verifiedTransac($ref)
    {
        $response = Http::withHeaders([
            'Authorization' => $this->token,
            'Accept' => 'application/json',
        ])->get('https://api.notchpay.co/payments/' . $ref);

        return $response->json();
    }

    // Confirmation de paiement
    public function confirmPay($ref, Request $request)
    {

        $channel = $request->input('channel');
        $data = $request->input('data');
        // Requete HTTP de confirmation de transaction NotchPay
        $transaction = $this->nocthRepository->confirmTransacRequest($channel, $data, $ref);

        return $transaction;
    }



    // Annulation d'une transaction
    public function cancelPay($ref)
    {

        // Requete HTTP d'annulation de transaction NotchPay
        $transaction =  $this->nocthRepository->cancelTransRequest($ref);

        return $transaction;
    }

    // Initialisation transaction pack mois Euroupe
    public function createRecipient(Request $request)
    {


        // Création de URL avec les paramètres en GET de la transaction
        // $params = [
        //     "channel" => "cm.mobile",
        //     "number" => "+237655091352",
        //     "phone" => "+237655091352",
        //     "email" => "",
        //     "country" => "CM",
        //     "name" => "Wilfrid Tiam",
        //     "description" => "Hic blanditiis voluptatem nobis ut saepe dolorem molestiae dolorum.",
        //     "reference" => "3RAV4gZLesBAXTrwiuUDLnJGSAS4RVEbM2"
        // ];
        $params = [
            "channel" => $request->channel,
            "number" => $request->phone,
            "phone" => $request->phone,
            "email" => "",
            "country" => $request->country,
            "name" => $request->name,
            "description" => $request->description,
            "reference" => $request->reference
        ];

        // Requete vers NotchPay pour l'initiation de la transaction
        $transaction = $this->nocthRepository->createRecipient($params);

        return $transaction;
    }

    public function getRecipient(Request $request)
    {

        // Requete vers NotchPay pour l'initiation de la transaction
        $transaction = $this->nocthRepository->getRecipient();

        return $transaction;
    }
}