@extends('layouts.template')

@section('contenu')
	<div class="nk-content">
		<div class="nk-block">
			<div class="row g-gs">
				<div class="container-fluid">
					<div class="row justify-content-center">
						<div class="" id="loader">
							<div class="spinner-grow text-primary" role="status">
								<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-primary" role="status">
								<span class="sr-only">Loading...</span>
							</div>
							<div class="spinner-grow text-primary" role="status">
								<span class="sr-only">Loading...</span>
							</div>
						</div>
						<div class="col-md-12" hidden id="block">
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
									<form method="POST" id="formCategory" action="#">
										@csrf
										<div class="row g-gs">
											<div class="col-md-12">
												<div class="form-group">
													<label style="font-weight: bold;" for="pictureupload">Image de la catégorie</label><br>
													<img src="" id="imgshow" width="100" alt=""><br><br>
													<input type="file" class="p-md-5 form-control" id="pictureupload" accept=".jpg, .jpeg, .png, .webp"
														value="">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<x-input name='libelle' input='text' :required="true" title="Nom de la catégorie *">
													</x-input>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<button type="submit" class="btn btn-lg btn-primary" id="btn-submit-categories"><span
															id="textSave">Sauvegarder</span>
														<div class="spinner-border" hidden id="loadSave" role="status">
															<span class="sr-only">Loading...</span>
														</div>
													</button>
													<button type="button" onclick="clearformCategory()" class="btn btn-lg btn-clear">@lang('Annuler')</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
	<script type="text/javascript">
		$(document).ready(function() {
			getCategorieInfo('{{ $id }}');
		});

		$("#btn-submit-categories").click(function(e) {
			e.preventDefault();

			if ($('#libelle').val()) {
				$('#alert-javascript').addClass('d-none');
				$('#alert-javascript').text('');
				$('#btn-submit-categories').attr('disabled', true);
				$("#textSave").attr("hidden", true);
				$("#loadSave").removeAttr("hidden");

				if (document.getElementById("pictureupload").files.length != 0) {

					//upload image
					const ref = firebase.storage().ref();
					const file = document.querySelector("#pictureupload").files[0];
					const name = +new Date() + "-" + file.name;
					const metadata = {
						contentType: file.type
					};
					const task = ref.child(name).put(file, metadata);
					task
						.then(snapshot => snapshot.ref.getDownloadURL())
						.then(url => {
							console.log(url);
							document.querySelector("#pictureupload").src = url;

							firebase
								.firestore()
								.collection("category")
								.doc("{{ $id }}")
								.update({
									img: url,
									name: document.querySelector("#libelle").value,
								})
								.then((ref) => {
									Swal.fire("Succès !",
										'Votre requête s\'est terminer avec succèss',
										'success', );
									clearformCategory();
								});
						})
						.catch(console.error);
				} else {
					firebase
						.firestore()
						.collection("category")
						.doc("{{ $id }}")
						.update({
							name: document.querySelector("#libelle").value,
						})
						.then((ref) => {
							Swal.fire("Succès !",
								'Votre requête s\'est terminer avec succèss', 'success', );
							clearformCategory();
						});
				}
			} else {
				$('#alert-javascript').removeClass('d-none');
				$('#alert-javascript').text('Veuillez remplir tous les champs');
			}
		});

		function getCategorieInfo(id) {
			var database = firebase.firestore();
			var ref = database.collection('category').doc('{{ $id }}').get().then((doc) => {
				console.log(doc.data());
				$("#libelle").val(doc.data()['name']);
				// $("#pictureupload").val(doc.data()['img']);
				$("#imgshow").attr('src', doc.data()['img']);

				$("#loader").attr("hidden", true);
				$("#block").removeAttr("hidden");
			});
			return true;
		}

		function clearformCategory() {
			$('#alert-javascript').addClass('d-none');
			$('#alert-javascript').text('');
			$("#libelle").val('');
			$("#libelle").focus();
			@if (Route::currentRouteName() === 'category.edit')
				history.pushState({}, null, "{{ route('category.index') }}");
				window.setTimeout('location.reload()', 1500);
				// window.setTimeout(' history.back();', 1500);
			@endif
			$("#pictureupload").val('');
			$('#btn-submit-categories').attr('disabled', false);
			$("#loadSave").attr("hidden", true);
			$("#textSave").removeAttr("hidden");
		}
	</script>
@endsection
