@extends('layouts.template_profile')

@section('css')
	{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css"> --}}
@endsection

@section('contenu')
	<div class="nk-content">
		<div class="nk-block">
			<div class="row g-gs">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-md-12">
							<div class="nk-block nk-block-lg">
								<div class="nk-block-head">
									<div class="nk-block-head-content">
										@if (session('status'))
											<br>
											<div class="alert alert-success alert-dismissible" role="alert">
												{{ session('status') }}
											</div>
										@endif
										<div class="alert alert-danger alert-dismissible d-none" id="alert-javascript" role="alert">
										</div>
										@if (count($errors) > 0)
											<br>
											<div class="alert alert-danger alert-dismissible" role="alert">
												<ul>
													@foreach ($errors->all() as $error)
														<li>{{ $error }}</li>
													@endforeach
												</ul>
											</div>
										@endif
									</div>
								</div>
								<div class="card">
									<div class="card-inner">
										<form method="POST" id="formUser" action="{{ route('user.update.profile', $user->id) }}">
											@csrf
											<h4>Profile</h4>
											<input type="text" id="id" name="id" value="{{ isset($user) ? $user->id : '0' }}" hidden>
											<div style="height: 20px"></div>
											<input type="text" id="id" name="id" value="{{ isset($user) ? $user->id : '0' }}" hidden>
											<div class="row g-gs">
												<div class="col-md-12">
													<div class="form-group">
														<x-input name='name' :value="isset($user) ? $user->name : ''" input='text' :required="true" title="Nom *">
														</x-input>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<x-input name='email' :disabled=true :value="isset($user) ? $user->email : ''" input='email' :required="true" title="Email *">
														</x-input>
													</div>
												</div>
												<div class="col-md-12">
													<div class="form-group">
														<button type="submit" class="btn btn-lg btn-primary btn-submit-user">Sauvegarder</button>
													</div>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div><!-- .nk-block -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection


@section('script')
	<script>
		$('.btn-submit-user').click(function(e) {
			$('#alert-javascript').addClass('d-none');
			$('#alert-javascript').text('');
			$('.btn-submit-user').attr('disabled', true);
			e.preventDefault();
			let name = $("#name").val();
			let email = $("#email").val();
			let id = $("#id").val();

			var formData = new FormData();
			formData.append('name', name);
			formData.append('email', email);
			formData.append('id', id);
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
				},
				url: "" + $('#formUser').attr('action'),
				type: "" + $('#formUser').attr('method'),
				dataType: 'json',
				data: formData,
				contentType: false,
				processData: false,
				success: function(data) {
					$('.btn-submit-user').attr('disabled', false);
					if ($.isEmptyObject(data.errors) && $.isEmptyObject(data.error)) {
						//success
						Swal.fire(data.success,
							'Votre requête s\'est terminer avec succèss', 'success', );
					} else {
						$('.btn-submit-user').attr('disabled', false);
						if (!$.isEmptyObject(data.error)) {
							$('#alert-javascript').removeClass('d-none');
							$('#alert-javascript').text(data.error);
						} else {
							if (!$.isEmptyObject(data.errors)) {
								var error = "";
								data.errors.forEach(element => {
									error = error + element + "<br>";
								});
								$('#alert-javascript').removeClass('d-none');
								$('#alert-javascript').append(error);
							}
						}
					}
					$("html, body").animate({
						scrollTop: 0
					}, "slow");
				},
				error: function(data) {
					$('.btn-submit-user').attr('disabled', false);
					Swal.fire('Une erreur s\'est produite.',
						'Veuilez contacté l\'administration et leur expliqué l\'opération qui a provoqué cette erreur.',
						'error');

				}
			});

		});

		$(function() {
			$('#pictureupload').change(function(event) {
				var x = URL.createObjectURL(event.target.files[0]);
				$('#show_img').attr('src', x);
				$('#show_img').attr('height', 150);
				$('#show_img').attr('width', 150);
			});
		});
	</script>
@endsection
