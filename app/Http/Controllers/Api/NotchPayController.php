<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\PayConfirmation;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Repositories\Api\NotchRepository;
use App\Models\{Plan};
use App\Repositories\PaymentRepository as RepositoriesPaymentRepository;
use App\Repositories\SubscriptionRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;

class NotchPayController extends Controller
{

    public function __construct(NotchRepository $nocthRepository)
    {
        $this->token = env("NOTCH_TOKEN_PRODUCTION");
        $this->nocthRepository = $nocthRepository;
        $this->middleware('auth.register')->only([
            'initTransacMonthCm', 'initTransacYearCm', 'initTransacMonthEuro',
            'initTransacMonthEuro'
        ]);
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



    // Initialisation transaction pack année Cameroun
    public function initTransacYearCm(Request $request)
    {

        $plan =  plan::basicYearCM(); // Appel des information du plan
        // Création de URL avec les paramètres en GET
        $params = [
            'email' => 'info@eland.cc',
            'currency' => $plan->devise,
            'amount' => $plan->price,
            'phone' => '691586219',
            'reference' => "{$plan->slug}|" . uniqid('', true) . uniqid('', true) . "EtG",
            'description' => 'Eland textGen ' . $plan->name,
        ];
        // Requete vers NotchPay pour l'initiation de la transaction
        $transaction = $this->nocthRepository->initTransac($params);
        // Sauvegarde du paiement initialisé dans le repository Payment
        $other_params = [
            'plan_id' => $plan->slug,
            'amount' => $plan->price,
            'currency' => $plan->devise,
            'payment_method' => null,
            'payment_processor' => env('NOTCH_NAME'),
            'status' => 'initiated',
        ];
        $rep = RepositoriesPaymentRepository::saveOrUpdatePayment('initiated', $transaction, $other_params, null);
        if (!$rep) {
            //Si la requête de création de paiement dans notre BD a échoué
            abort(500);
        }
        return view('payment.nocthPay.cm.basic-year', ['transaction' => $transaction, 'plan' => $plan]);
    }

    // Initialisation transaction pack mois Cameroun
    public function initTransacMonthCm(Request $request)
    {

        $plan =  plan::basicMonthCM(); // Appel des information du plan
        // Création de URL avec les paramètres en GET de la transaction
        $params = [
            'email' => 'info@eland.cc',
            'currency' => $plan->devise,
            'amount' => $plan->price,
            'phone' => '691586219',
            'reference' => "{$plan->slug}|" . uniqid('', true) . uniqid('', true) . "EtG",
            'description' => 'Eland textGen ' . $plan->name,
        ];

        // Requete vers NotchPay pour l'initiation de la transaction
        $transaction = $this->nocthRepository->initTransac($params);

        // Sauvegarde du paiement initialisé dans le repository Payment
        $other_params = [
            'plan_id' => $plan->slug,
            'amount' => $plan->price,
            'currency' => $plan->devise,
            'payment_method' => null,
            'payment_processor' => env('NOTCH_NAME'),
            'status' => 'initiated',
        ];
        $rep = RepositoriesPaymentRepository::saveOrUpdatePayment('initiated', $transaction, $other_params, null);
        if (!$rep) {
            //Si la requête de création de paiement dans notre BD a échoué
            abort(500);
        }

        return view('payment.nocthPay.cm.basic-month', ['transaction' => $transaction, 'plan' => $plan]);
    }


    // Initialisation transaction pack année Europe
    public function initTransacYearEuro(Request $request)
    {

        $plan =  plan::basicYear(); // Appel des information du plan
        // Création de URL avec les paramètres en GET
        $params = [
            'email' => 'info@eland.cc',
            'currency' => $plan->devise,
            'amount' => $plan->price,
            'phone' => '691586219',
            'reference' => "{$plan->slug}|" . uniqid('', true) . uniqid('', true) . "EtG",
            'description' => 'Eland textGen ' . $plan->name,
        ];



        // Requete vers NotchPay pour l'initiation de la transaction
        $transaction = $this->nocthRepository->initTransac($params);

        // Sauvegarde du paiement initialisé dans le repository Payment
        $other_params = [
            'plan_id' => $plan->slug,
            'amount' => $plan->price,
            'currency' => $plan->devise,
            'payment_method' => null,
            'payment_processor' => env('NOTCH_NAME'),
            'status' => 'initiated',
        ];
        $rep = RepositoriesPaymentRepository::saveOrUpdatePayment('initiated', $transaction, $other_params, null);
        if (!$rep) {
            //Si la requête de création de paiement dans notre BD a échoué
            abort(500);
        }

        // Retourner la vue + param
        return view('payment.nocthPay.euro.basic-year', ['transaction' => $transaction, 'plan' => $plan]);
    }

    // Initialisation transaction pack mois Euroupe
    public function initTransacMonthEuro(Request $request)
    {

        $plan =  plan::basicMonth(); // Appel des information du plan
        // Création de URL avec les paramètres en GET de la transaction
        $params = [
            'email' => 'info@eland.cc',
            'currency' => $plan->devise,
            'amount' => 2.99,
            'phone' => '691586219',
            'reference' => "{$plan->slug}|" . uniqid('', true) . uniqid('', true) . "EtG",
            'description' => 'Eland textGen ' . $plan->name,
        ];

        // Requete vers NotchPay pour l'initiation de la transaction
        $transaction = $this->nocthRepository->initTransac($params);

        // Sauvegarde du paiement initialisé dans le repository Payment
        $other_params = [
            'plan_id' => $plan->slug,
            'amount' => $plan->price,
            'currency' => $plan->devise,
            'payment_method' => null,
            'payment_processor' => env('NOTCH_NAME'),
            'status' => 'initiated',
        ];
        $rep = RepositoriesPaymentRepository::saveOrUpdatePayment('initiated', $transaction, $other_params, null);
        if (!$rep) {
            //Si la requête de création de paiement dans notre BD a échoué
            abort(500);
        }

        return view('payment.nocthPay.euro.basic-month', ['transaction' => $transaction, 'plan' => $plan]);
    }

    // Vérification de l'etat d'une transaction
    public function verifiedTransac($ref)
    {
        $response = Http::withHeaders([
            'Authorization' => $this->token,
            'Accept' => 'application/json',
        ])->get('https://api.notchpay.co/payments/' . $ref);

        if ($response->successful()) {
            // La requête a réussi
            $other_params = [
                'status' => 'paid',
            ];
            $params = $response['transaction'];
            if ($params['status'] == 'complete') {
                $rep = RepositoriesPaymentRepository::saveOrUpdatePayment('paid', null, $other_params, $ref);

                if (isset($rep) && $rep->status == 'paid') {
                    // Sauvegarde l'abonnement
                    $subscription = SubscriptionRepository::saveSubscription($ref);
                    if (isset($subscription)) {
                        //Envoie du mail de confirmation
                        $lang = Lang::locale();
                        Mail::to($subscription->user->email)->locale($lang)
                            ->queue(new PayConfirmation($subscription));
                    }
                }
            }
            return $response->json();
        }

        if ($response->failed()) {
            // La requête a échoué
            return $response->json();
        }
    }

    // Confirmation de paiement
    public function confirmPay($ref, Request $request)
    {

        $channel = $request->input('channel');
        $data = $request->input('data');
        // Requete HTTP de confirmation de transaction NotchPay
        $transaction = $this->nocthRepository->confirmTransacRequest($channel, $data, $ref);

        $other_params = [
            'payment_method' => $channel,
            'payment_processor_json' => $data,
            'status' => 'pending',
        ];

        $rep = RepositoriesPaymentRepository::saveOrUpdatePayment('pending', $transaction, $other_params, $ref);

        return $transaction;
    }



    // Annulation d'une transaction
    public function cancelPay($ref)
    {

        // Requete HTTP d'annulation de transaction NotchPay
        $transaction =  $this->nocthRepository->cancelTransRequest($ref);
        $other_params = [
            'status' => 'cancelled',
        ];

        $rep = RepositoriesPaymentRepository::saveOrUpdatePayment('cancelled', $transaction, $other_params, $ref);

        return $transaction;
    }
}