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
									<form method="POST" id="formProduct" action="#">
										@csrf
										<div class="row g-gs">
											<div class="col-md-12">
												<div class="form-group">
													<label style="font-weight: bold;" for="pictureupload">Image du produit</label><br>
													<img src="" id="imgshow" width="100" alt=""><br><br>
													<input type="file" class="p-md-5 form-control" id="pictureupload" accept=".jpg, .jpeg, .png, .webp"
														value="">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<x-input name='libelle' input='text' :required="true" title="Nom du produit *">
													</x-input>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<x-input name='description' input='textarea' :required="true" title="description du produit *">
													</x-input>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<x-input name='price' input='number' :required="true" title="Prix du produit *">
													</x-input>
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<button type="submit" class="btn btn-lg btn-primary" id="btn-submit-products"><span
															id="textSave">Sauvegarder</span>
														<div class="spinner-border" hidden id="loadSave" role="status">
															<span class="sr-only">Loading...</span>
														</div>
													</button>
													<button type="button" onclick="clearformProduct()" class="btn btn-lg btn-clear">@lang('Annuler')</button>
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
			getProductInfo();
		});

		$("#btn-submit-products").click(function(e) {
			e.preventDefault();

			if ($('#libelle').val() &&
				$('#description').val() &&
				$('#price').val()
			) {
				$('#alert-javascript').addClass('d-none');
				$('#alert-javascript').text('');
				$('#btn-submit-products').attr('disabled', true);
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
								.collection("products")
								.doc("{{ $id }}")
								.update({
									modified_at: firebase.firestore.FieldValue.serverTimestamp(),
									img: url,
									name: document.querySelector("#libelle").value,
									description: $('#description').val(),
									price: $('#price').val(),
								})
								.then((ref) => {

									Swal.fire("Succès !",
										'Votre requête s\'est terminer avec succèss',
										'success', );
									clearformProduct();

								});
						})
						.catch(console.error);
				} else {
					firebase
						.firestore()
						.collection("products")
						.doc("{{ $id }}")
						.update({
							name: document.querySelector("#libelle").value,
							modified_at: firebase.firestore.FieldValue.serverTimestamp(),
							description: $('#description').val(),
							price: $('#price').val(),
						})
						.then((ref) => {
							Swal.fire("Succès !",
								'Votre requête s\'est terminer avec succèss', 'success', );
							clearformProduct();
						});
				}
			} else {
				$('#alert-javascript').removeClass('d-none');
				$('#alert-javascript').text('Veuillez remplir tous les champs');
			}
		});

		function getProductInfo() {
			var database = firebase.firestore();
			var ref = database.collection('products').doc('{{ $id }}').get().then((doc) => {
				console.log(doc.data());
				$("#libelle").val(doc.data()['name']);
				$("#description").val(doc.data()['description']);
				$("#price").val(doc.data()['price']);
				$("#imgshow").attr('src', doc.data()['img']);

				$("#loader").attr("hidden", true);
				$("#block").removeAttr("hidden");
			});
			return true;
		}

		function clearformProduct() {
			$('#alert-javascript').addClass('d-none');
			$('#alert-javascript').text('');
			$("#libelle").val('');
			$("#description").val('');
			$("#price").val('');
			$("#libelle").focus();
			$("#pictureupload").val('');
			$('#btn-submit-products').attr('disabled', false);
			$("#loadSave").attr("hidden", true);
			$("#textSave").removeAttr("hidden");
			@if (Route::currentRouteName() === 'products.edit')
				history.pushState({}, null, "{{ route('products.index') }}");
				window.setTimeout('location.reload()', 1500);
				// window.setTimeout(' history.back();', 1500);
			@endif
		}
	</script>
@endsection
