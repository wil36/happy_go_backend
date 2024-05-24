<!DOCTYPE html>
<html lang="fr" dir="ltr">

    <head>
        <base href="../">
        <meta charset="utf-8">
        <meta charset="utf-8">
        <meta name="author" content="Nat Finance">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Application de tontine numérique">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Fav Icon  -->
        <link rel="shortcut icon" href="{!! asset('images/favicon.png') !!}">
        <!-- Page Title  -->
        <title>@yield('title')</title>
        <!-- StyleSheets  -->
        <link rel="stylesheet" href="{!! asset('assets/css/dashlite.css?ver=2.7.0') !!}">
        <link id="skin-default" rel="stylesheet" href="{!! asset('assets/css/theme.css?ver=2.2.0') !!}">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
        @yield('css')
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
                                                <h2 class="nk-block-title fw-normal">@yield('title')</h2>
                                                <div class="nk-block-des">
                                                    <p class="lead">Nous sommes engagés dans une mission pour améliorer le web. Les conditions suivantes, ainsi que notre Politique et Conditions d’Utilisation, s’appliquent à tous les utilisateurs.</p>
                                                    <p class="text-soft ff-italic">Dernière mise à jour : 23 Mai 2024</p>
                                                </div>
                                            </div>
                                        </div><!-- .nk-block-head -->
                                        <div class="nk-block">
                                            <div class="card">
                                                <div class="card-inner card-inner-xl">
                                                    <div class="entry">
                                                        @yield('content')
                                                    </div>
                                                </div><!-- .card-inner -->
                                            </div><!-- .card -->
                                        </div><!-- .nk-block -->
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