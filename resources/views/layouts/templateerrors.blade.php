<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<base href="../">
	<meta charset="utf-8">
	<meta charset="utf-8">
	<meta name="author" content="Nat Finance">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Application de Covoiturage">
	<!-- Fav Icon  -->
	<link rel="shortcut icon" href="./images/favicon.png">
	<!-- Page Title  -->
	<title>@lang('Happy Go')</title>
	<!-- StyleSheets  -->
	<link rel="stylesheet" href="{!! asset('assets/css/dashlite.css?ver=2.2.0') !!}">
	<link id="skin-default" rel="stylesheet" href="{!! asset('assets/css/theme.css?ver=2.2.0') !!}">
	<link rel="stylesheet" href="{!! asset('assets/css/style-email.css') !!}">

</head>

<body class="no-touch nk-nio-theme @yield('dark')">
	@yield('contenu')

	{{-- Script js --}}
	<script src="{!! asset('assets/js/bundle.js?ver=2.2.0') !!}"></script>
	<script src="{!! asset('assets/js/scripts.js?ver=2.2.0') !!}"></script>
	<script src="{!! asset('assets/js/libs/jkanban.js?ver=2.2.0') !!}"></script>
	{{-- <script src="{!! asset('assets/js/apps/kanban.js?ver=2.2.0') !!}"></script> --}}
	<script src="{!! asset('js/jquery.min.js') !!}"></script>
	@yield('script')
</body>

</html>
