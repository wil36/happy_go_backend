<!DOCTYPE html>
<html lang="fr" dir="ltr">

    <head>
        <base href="../">
        <meta charset="utf-8">
        <meta charset="utf-8">
        <meta name="author" content="Nat Finance">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Application de Covoiturage">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Fav Icon  -->
        <link rel="shortcut icon" href="{!! asset('images/favicon.png') !!}">
        <!-- Page Title  -->
        <title>Suppression de Compte</title>
        <!-- StyleSheets  -->
        <link rel="stylesheet" href="{!! asset('assets/css/dashlite.css?ver=2.7.0') !!}">
        <link id="skin-default" rel="stylesheet" href="{!! asset('assets/css/theme.css?ver=2.2.0') !!}">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
        @yield('css')
        <style>
            strong {
                font-weight: 900;
            }
        </style>
    </head>


    <body class="no-touch nk-nio-theme">
        <div class="nk-app-root">
            <!-- main @s -->
            <div class="nk-main ">
                <!-- wrap @s -->
                <div class="nk-wrap ">
                    <!-- main header @s -->
                   
                    <!-- main header @e -->
                    <!-- content @s -->
                    <div class="nk-content ">
                        <div class="container-fluid">
                            <div class="nk-content-inner">
                                <div class="nk-content-body">
                                    <div class="content-page wide-md m-auto">
                                        <div class="nk-block-head nk-block-head-lg wide-sm mx-auto">
                                            <div class="nk-block-head-content text-center">
                                                <h2 class="nk-block-title fw-normal">Suppression de Compte</h2>
                                                <div class="nk-block-des">
                                                    <p class="lead">Pour supprimer votre compte, veuillez cliquer sur le lien ci-dessous :</p>
                                                    <p class="text-soft ff-italic">Veuillez remplir les informations requises telles que votre <strong>nom, numéro de téléphone et numéro de la Carte Nationale d'Identité (CNI) </strong>camerounaise.</p>
                                                    <p><a class="btn btn-dim btn-outline-danger" href="mailto:privacy@votreapp.com?subject=Demande%20de%20Suppression%20de%20Compte&body=Cher%20Service%20de%20Confidentialit%C3%A9%2C%0D%0A%0D%0AJe%20souhaite%20supprimer%20mon%20compte%20et%20toutes%20les%20donn%C3%A9es%20associ%C3%A9es%20de%20l\'application%20[Nom%20de%20l\'Application%20de%20Covoiturage].%20Veuillez%20trouver%20ci-dessous%20mes%20informations%20pour%20v%C3%A9rifier%20mon%20identit%C3%A9%20et%20traiter%20ma%20demande.%0D%0A%0D%0ANom%20%3A%20[Le%20Nom%20Complet%20de%20l\'Utilisateur]%0D%0ANum%C3%A9ro%20de%20T%C3%A9l%C3%A9phone%20%3A%20[Le%20Num%C3%A9ro%20de%20T%C3%A9l%C3%A9phone%20de%20l\'Utilisateur]%0D%0ANum%C3%A9ro%20de%20la%20Carte%20d\'Identit%C3%A9%20Camerounaise%20%3A%20[Le%20Num%C3%A9ro%20de%20la%20Carte%20d\'Identit%C3%A9%20Camerounaise]%0D%0A%0D%0AJe%20comprends%20que%20cette%20action%20est%20irr%C3%A9versible%20et%20entra%C3%AEnera%20la%20suppression%20de%20toutes%20mes%20donn%C3%A9es%20personnelles%20et%20de%20mon%20historique%20de%20trajets.%0D%0A%0D%0AMerci%20de%20confirmer%20la%20r%C3%A9ception%20de%20cette%20demande%20et%20de%20m\'informer%20une%20fois%20que%20la%20suppression%20a%20%C3%A9t%C3%A9%20effectu%C3%A9e.%0D%0A%0D%0ACordialement%2C%0D%0A[Le%20Nom%20Complet%20de%20l\'Utilisateur]">Supprimer Mon Compte</a></p>
                                                </div>
                                            </div>
                                        </div><!-- .nk-block-head -->
                                    </div><!-- .content-page -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- content @e -->
                    <!-- footer @s -->
                    <div class="nk-footer">
                        <div class="container-fluid">
                            <div class="nk-footer-wrap">
                                <div class="nk-footer-copyright"> &copy; {{ date('Y') }} Happy Go. By <a href="https://eland.cc" target="_blank">Eland</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- footer @e -->
                </div>
                <!-- wrap @e -->
            </div>
            <!-- main @e -->
        </div>
    </body>

    <script src="{!! asset('assets/js/bundle.js?ver=2.2.0') !!}"></script>
	<script src="{!! asset('assets/js/jszip.min.js') !!}"></script>
	<script src="{!! asset('assets/js/scripts.js?ver=2.2.0') !!}"></script>
	<script src="{!! asset('assets/js/csvExport.min.js?ver=2.2.0') !!}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"
		integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</html>