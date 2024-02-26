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
						<div class="col-md-12" id="block" hidden>
							<div class="nk-block nk-block-lg">


								<div class="col-md-4">
									<a href="{{ route('products.create') }}" class="btn btn-primary" id="export-pending">Ajouter un produit</a>
								</div><br>
								<div class="card card-preview">
									<div class="card-inner table-responsive">
										<table class="nk-tb-list nk-tb-ulist">
											<thead>
												<tr class="nk-tb-item nk-tb-head">
													<th class="nk-tb-col nk-tb-col-check">
														<div class="custom-control custom-control-sm custom-checkbox notext">
															<input type="checkbox" class="custom-control-input" id="customCheckAllOuvert">
															<label class="custom-control-label" for="customCheckAllOuvert"></label>
														</div>
													</th>
													<th class="nk-tb-col tb-col-mb" width="20%"><span class="sub-text">Nom</span></th>
													<th class="nk-tb-col tb-col-mb" width="30%"><span class="sub-text">Description</span></th>
													<th class="nk-tb-col tb-col-md"><span class="sub-text">Date de création</span></th>
													<th class="nk-tb-col tb-col-lg"><span class="sub-text">Prix</span></th>
													<th class="nk-tb-col nk-tb-col-tools text-right">Action
													</th>
												</tr>
											</thead>
											<tbody id="products-list">
												<img src="" alt="">
											</tbody>
										</table>
									</div>
								</div><!-- .card-preview -->

							</div> <!-- nk-block -->
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
			getproducts();
		});

		function deleteProduct(id) {
			Swal.fire({
				title: 'Voulez-vous vraiment supprimer ce produit ?',
				text: "Vous êtes en train de vouloir supprimer ce produit ! Assurez-vous que c'est bien la bonnne !",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Oui',
				cancelButtonText: 'Annuler',
			}).then((result) => {
				if (result.value) {
					var database = firebase.firestore();
					database.collection('products').doc(id).delete().then(() => {
						Swal.fire("Succès !",
							'Votre requête s\'est terminer avec succèss',
							'success', );
						console.log("Document updated"); // Document updated
						location.reload();
					});
				}
			});
		}

		function getproducts() {
			var database = firebase.firestore();
			var ref = database.collection('products').orderBy("created_at", "desc").limit(500).get().then((querySnapshot) => {
				console.log(querySnapshot);
				if (querySnapshot.empty == false) {

					$("#loader").attr("hidden", true);
					$("#block").removeAttr("hidden");
					console.log(querySnapshot);
					$("#products-list").html('');
					querySnapshot.forEach((doc) => {
						console.log(doc.id, " => ", doc.data());
						let route = "{{ route('products.edit', '') }}/" +
							doc.id;
						$("#products-list").append('\'<tr class="nk-tb-item">' +
							'<td class="nk-tb-col nk-tb-col-check">' +
							'<div class="custom-control custom-control-sm custom-checkbox notext">' +
							'<input type="checkbox" class="custom-control-input" id="' + doc.id +
							'">' +
							'<label class="custom-control-label" for="' + doc.id + '"></label>' +
							'</div>' +
							'</td>' +
							'<td class="nk-tb-col">' +
							'<div class="user-card">' +
							'<div class="user-avatar bg-dim-primary d-none d-sm-flex">' +
							'<span><img src="' + doc.data()['img'] + '"></span>' +
							'</div>' +
							'<span>' + doc.data()["name"] + '</span>' +
							'</div>' +
							'</td>' +
							'<td class="nk-tb-col tb-col-mb">' +
							'<span>' + doc.data()["description"] + '</span>' +
							'</td>' +
							'<td class="nk-tb-col tb-col-mb">' +
							'<span>' + Date(doc.data()["created_at"] * 1000).slice(0, 25) + '</span>' +
							'</td>' +
							'<td class="nk-tb-col tb-col-md">' +
							'<div class="user-info">' +
							'<span class="tb-lead">' + doc.data()["price"] +
							' €<span class="dot dot-success d-md-none ml-1"></span></span>' +
							'<span></span>' +
							'</div>' +
							'</td>' +
							'<td class="nk-tb-col nk-tb-col-tools">' +
							'<ul class="nk-tb-actions gx-1">' +
							'<li class="nk-tb-action-hidden">' +
							'<a href=" ' + route +
							'" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top"' +
							'title="modifier">' +
							'<em class="icon ni ni-pen"></em>' +
							'</a>' +
							'</li>' +
							'<li class="nk-tb-action-hidden">' +
							'<a  class="btn btn-trigger btn-icon" onclick=deleteProduct("' + doc.id +
							'"); data-toggle="tooltip" data-placement="top"' +
							'title="Suprimer">' +
							'<em class="icon ni ni-trash-alt"></em>' +
							'</a>' +
							'</li>' +
							'</ul>' +
							'</td>' +
							'</tr><!-- .nk-tb-item \'');
					});
				}
			});


		}
	</script>
@endsection
