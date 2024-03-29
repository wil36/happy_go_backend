@php $locale = session()->get('locale'); @endphp
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<base href="../">
	<meta charset="utf-8">
	<meta name="author" content="Ma Beac">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Mutelle Ma Beac">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="">
	<!-- Fav Icon  -->
	<link rel="shortcut icon" href="{!! asset('images/favicon.png') !!}">
	<!-- Page Title  -->
	<title>@lang('Happy Go')</title>
	<!-- StyleSheets  -->
	<link rel="stylesheet" href="{!! asset('assets/css/dashlite.css?ver=2.7.0') !!}">
	<link id="skin-default" rel="stylesheet" href="{!! asset('assets/css/theme.css?ver=2.7.0') !!}">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
	@yield('css')
</head>

<body @php
$userinfo = Auth::user(); @endphp
	class="no-touch nk-nio-theme @if ($userinfo->theme == 1) dark-mode @endif">
	">
	<div class="nk-app-root">
		<!-- main @s -->
		<div class="nk-main">
			<!-- wrap @s -->
			<div class="nk-wrap">
				<div class="nk-header nk-header-fixed nk-header-fluid is-light">
					<div class="container-fluid">
						<div class="nk-header-wrap">
							<div class="nk-menu-trigger d-xl-none ml-n1">
								<a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em
										class="icon ni ni-menu-alt-left"></em></a>
							</div>
							<div class="nk-header-brand d-xl-none">
								<a href="{{ route('dashboard') }}" class="logo-link">
									<img class="logo-light logo-img logo-img-lg" src="{{ asset('images/logo.png') }}"
										srcset="{{ asset('images/logo.png') }}" alt="logo">
									<img class="logo-dark logo-img logo-img-lg" src="{{ asset('images/logo.png') }}"
										srcset="{{ asset('images/logo.png') }}" alt="logo-dark">
								</a>
							</div><!-- .nk-header-brand -->
							<div class="nk-header-search ml-xl-0 ml-3">
								<a href="{{ url()->previous() }}">
									<h4><em class="icon ni ni-back-ios"></em> Retour</h4>
								</a>
							</div><!-- .nk-header-news -->
							<div class="nk-header-tools">
								<ul class="nk-quick-nav">
									{{-- <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            @switch($locale)
                                                @case('en')
                                                    <img src="{{ asset('images/usa.png') }}" width="25px">
                                                    @lang('Anglais')
                                                @break
                                                @case('fr')
                                                    <img src="{{ asset('images/france.png') }}" width="25px">
                                                    @lang('Français')
                                                @break
                                                @default
                                                    <img src="{{ asset('images/france.png') }}" width="25px">
                                                    @lang('Français')
                                            @endswitch
                                            <span class="caret"></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('lang', 'en') }}"><img
                                                    src="{{ asset('images/usa.png') }}" width="25px">
                                                @lang('Anglais')</a>
                                            <a class="dropdown-item" href="{{ route('lang', 'fr') }}"><img
                                                    src="{{ asset('images/france.png') }}" width="25px">
                                                @lang('Français')</a>
                                        </div>
                                    </li> --}}
									<li class="dropdown user-dropdown">
										<a href="#" class="dropdown-toggle mr-n1" data-toggle="dropdown">
											<div class="user-toggle">
												<span style="margin-right: 10px;">
													{{ $userinfo->name }}</span>
												<div class="user-avatar sm">
													<img class="h-8 w-8 rounded-full object-cover"
														src="{{ isset($userinfo->profile_photo_path) ? asset('picture_profile/' . $userinfo->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . $userinfo->name . '&background=c7932b&size=150&color=fff' }}"
														alt="" />
												</div>
											</div>
										</a>
									</li>
								</ul>
							</div>
						</div><!-- .nk-header-wrap -->
					</div><!-- .container-fliud -->
				</div>
				@yield('contenu')
			</div>
		</div>
	</div>

	<!-- Modal Trigger Code -->
	{{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalDefault">Modal Default</button> --}}

	<!-- Modal Content Code -->
	<div class="modal fade" tabindex="-1" id="view-photo-modal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<a href="#" class="close" data-dismiss="modal" aria-label="Close">
					<em class="icon ni ni-cross"></em>
				</a>
				{{-- <div class="modal-header">
                    <h5 class="modal-title">Modal Title</h5>
                </div> --}}
				<div class="modal-body">
					<img src="" alt="" id="photo-modal">
				</div>
				{{-- <div class="modal-footer bg-light">
                    <span class="sub-text">Modal Footer Text</span>
                </div> --}}
			</div>
		</div>
	</div>
	{{-- Script js --}}
	<script src="{!! asset('assets/js/bundle.js?ver=2.7.0') !!}"></script>
	<script src="{!! asset('assets/js/scripts.js?ver=2.7.0') !!}"></script>
	<script src="{!! asset('assets/js/libs/datatable-btns.js') !!}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"
		integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	{{-- <script src="{!! asset('assets/js/charts/chart-ecommerce.js?ver=2.7.0') !!}"></script> --}}


	@yield('script')
	<script>
		$(document).on('click', '.popup-image', function(e) {
			e.preventDefault();
			var src = $(this).attr('src');
			$('#photo-modal').attr('src', src);
			// $('#modalDefault').modal({
			//     show: 'false'
			// });
		});
		$(document).ready(function() {
			$('.active').removeClass('.active');
		});
		$("#dark1").click(function() {
			$.ajax({
				type: 'GET',
				url: '{{ route('theme') }}',
				success: function(data) {},
				error: function() {
					console.error(data);
				}
			});
		});


		function nombresAvecEspaces(x) {
			return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
		}
	</script>

</body>

</html>
