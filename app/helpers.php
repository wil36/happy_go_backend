<?php

use Illuminate\Support\Facades\Route;


/**
 * currentRouteActive verifie si la route active correspond à l'une des route passer en paramètre 
 *
 * @param  mixed $routes liste des routes avec le quel on compare la route active
 * @return void
 */
if (!function_exists('currentRouteActive')) {

  function currentRouteActive(...$routes)
  {
    foreach ($routes as $route) {
      if (Route::currentRouteNamed($route)) return 'active current-page';
    }
  }
}

if (!function_exists('currentChildActive')) {
  function currentChildActive($children)
  {
    foreach ($children as $child) {
      if (Route::currentRouteNamed($child['route'])) return 'active';
    }
  }
}

if (!function_exists('menuOpen')) {
  function menuOpen($children)
  {
    foreach ($children as $child) {
      if (Route::currentRouteNamed($child['route'])) return 'menu-open';
    }
  }
}

if (!function_exists('isRole')) {
  function isRole($role)
  {
    return auth()->user()->role === $role;
  }
}

if (!function_exists('formatHour')) {
  function formatHour($date)
  {
    return ucfirst(utf8_encode($date->formatLocalized('%Hh%M')));
  }
}

if (!function_exists('formatDate')) {
  function formatDate($date)
  {
    return ucfirst(utf8_encode($date->formatLocalized('%d %B %Y')));
  }
}

if (!function_exists('sendFcm')) {
  function sendFcm($token_user, $title, $body, $type)
  {
    $SERVER_API_KEY = 'AAAAoeQektg:APA91bHIlIta63SdTWR7H4cz-NeySb82oNFACpr0mqbU0XXEQO_tGGC-RBUFbETQgbIgCYFBjyiQZ25iGMeY1gROucR6OvBqFPxoPboM1QJ0eQtDfdvPAnCggZoAwSM59fREpok7yDQ1';
    $data = [
      "registration_ids" => [
        $token_user
      ],
      "notification" => [

        "title" => $title,

        "body" => $body,
        'type' => $type,

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

if (!function_exists('sendFcmGroup')) {
  function sendFcmGroup($token_users, $title, $body, $type)
  {
    $SERVER_API_KEY = 'AAAAoeQektg:APA91bHIlIta63SdTWR7H4cz-NeySb82oNFACpr0mqbU0XXEQO_tGGC-RBUFbETQgbIgCYFBjyiQZ25iGMeY1gROucR6OvBqFPxoPboM1QJ0eQtDfdvPAnCggZoAwSM59fREpok7yDQ1';
    $data = [
      "registration_ids" => $token_users,
      "notification" => [

        "title" => $title,

        "body" => $body,
        'type' => $type,

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
