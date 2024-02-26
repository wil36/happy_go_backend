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
									<!-- Modal Trigger Code -->
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalDefault">Ajouter un
										produit</button>
								</div><br>
								<div class="col-md-4">
									<h4 id="categoryname"></h4><br>
								</div>
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




	<!-- Modal Content Code -->
	<div class="modal fade" tabindex="-1" id="modalDefault">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<a href="#" class="close" data-dismiss="modal" aria-label="Close">
					<em class="icon ni ni-cross"></em>
				</a>
				<div class="modal-header">
					<h5 class="modal-title">Nouveau produit</h5>
				</div>
				<div class="modal-body">
					<div class="card card-preview">
						<div class="card-inner table-responsive">
							<table class="nk-tb-list nk-tb-ulist">
								<thead>
									<tr class="nk-tb-item nk-tb-head">
										{{-- <th class="nk-tb-col nk-tb-col-check">
											<div class="custom-control custom-control-sm custom-checkbox notext">
												<input type="checkbox" class="custom-control-input" id="customCheckAllOuvert">
												<label class="custom-control-label" for="customCheckAllOuvert"></label>
											</div>
										</th> --}}
										<th class="nk-tb-col tb-col-mb" width="20%"><span class="sub-text">Nom</span></th>
										<th class="nk-tb-col tb-col-mb" width="30%"><span class="sub-text">Description</span></th>
										<th class="nk-tb-col tb-col-lg"><span class="sub-text">Prix</span></th>
										<th class="nk-tb-col nk-tb-col-tools text-right">Action
										</th>
									</tr>
								</thead>
								<tbody id="products-list-modal">
									<img src="" alt="">
								</tbody>
							</table>
						</div>
					</div><!-- .card-preview -->
				</div>
				<div class="modal-footer bg-light">
					<span class="sub-text"></span>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
	<script type="text/javascript">
		$(document).ready(function() {
			getproducts();
			getproductsModal();
		});

		function getproductsModal() {
			var database = firebase.firestore();
			var ref = database.collection('products').orderBy("created_at", "desc").limit(500).get().then((querySnapshot) => {
				console.log(querySnapshot);
				if (querySnapshot.empty == false) {

					$("#loader").attr("hidden", true);
					$("#block").removeAttr("hidden");
					console.log(querySnapshot);
					$("#products-list-modal").html('');
					querySnapshot.forEach((doc) => {
						console.log(doc.id, " => ", doc.data());
						let route = "{{ route('products.edit', '') }}/" +
							doc.id;
						$("#products-list-modal").append('\'<tr class="nk-tb-item">' +
							// '<td class="nk-tb-col nk-tb-col-check">' +
							// '<div class="custom-control custom-control-sm custom-checkbox notext">' +
							// '<input type="checkbox" class="custom-control-input" id="' + doc.id +
							// '">' +
							// '<label class="custom-control-label" for="' + doc.id + '"></label>' +
							// '</div>' +
							// '</td>' +
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
							'<a  class="btn btn-trigger btn-icon" onclick=addProductModal("' + doc
							.data()['id'] +
							'"); data-toggle="tooltip" data-placement="top"' +
							'title="Ajouter">' +
							'<em class="icon ni ni-plus-c"></em>' +
							'</a>' +
							'</li>' +
							'</ul>' +
							'</td>' +
							'</tr><!-- .nk-tb-item \'');
					});
				}
			});


		}

		function addProductModal(id) {
			Swal.fire({
				title: 'Voulez-vous vraiment ajouter ce produit ?',
				text: "Vous êtes en train de vouloir ajouter ce produit ! Assurez-vous que c'est bien la bon !",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Oui',
				cancelButtonText: 'Annuler',
			}).then((result) => {
				if (result.value) {
					console.log(id);
					var database = firebase.firestore();
					database.collection('category').doc("{{ $id }}").get().then((doc) => {
						// console.log(doc.id, " => ", doc.data()['productsList']);
						var productsList = doc.data()['productsList'];
						productsList.push(parseInt(id));
						database.collection('category').doc("{{ $id }}").update({
							productsList: productsList,
						}).then(() => {
							getproducts();
							Swal.fire("Succès !",
								'Votre requête s\'est terminer avec succèss',
								'success', );
						});
					});

				}
			});
		}

		function deleteProduct(id) {
			Swal.fire({
				title: 'Voulez-vous vraiment supprimer ce produit ?',
				text: "Vous êtes en train de vouloir supprimer ce produit ! Assurez-vous que c'est bien la bon !",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Oui',
				cancelButtonText: 'Annuler',
			}).then((result) => {
				if (result.value) {
					console.log(id);
					var database = firebase.firestore();
					database.collection('category').doc("{{ $id }}").get().then((doc) => {
						// console.log(doc.id, " => ", doc.data()['productsList']);
						var productsList = doc.data()['productsList'];
						var resultsArray = [];
						var promises = productsList.map((item) => {
							if (item != id) {
								resultsArray.push(item);
							}
						});
						Promise.all(promises)
							.then(function() {
								database.collection('category').doc("{{ $id }}").update({
									productsList: resultsArray,
								}).then(() => {
									getproducts();
									Swal.fire("Succès !",
										'Votre requête s\'est terminer avec succèss',
										'success', );
								});
							});
					});

				}
			});
		}

		function getproducts() {
			var database = firebase.firestore();
			var cat = database.collection('category').doc("{{ $id }}").get().then((doc) => {
				console.log(doc.id, " => ", doc.data()['productsList']);
				$('#categoryname').text(doc.data()['name']);
				var productsList = doc.data()['productsList'];
				var resultsArray = [];
				// Parcourir chaque élément de productsList
				// Utiliser Promise.all pour attendre que toutes les requêtes soient terminées
				var promises = productsList.map(function(productId) {
					return database.collection('products').where('id', '==', productId)
						.get()
						.then(function(querySnapshot) {
							querySnapshot.forEach(function(doc) {
								// Traitez chaque document ici
								resultsArray.push(doc.data());
							});
						})
						.catch(function(error) {
							console.log(error);
						});
				});
				Promise.all(promises)
					.then(function() {
						$("#products-list").html('');
						resultsArray.forEach(function(product) {
							console.log(product);
							$("#products-list").append('\'<tr class="nk-tb-item">' +
								'<td class="nk-tb-col nk-tb-col-check">' +
								'<div class="custom-control custom-control-sm custom-checkbox notext">' +
								'<input type="checkbox" class="custom-control-input" id="' + product
								.id +
								'">' +
								'<label class="custom-control-label" for="' + product.id +
								'"></label>' +
								'</div>' +
								'</td>' +
								'<td class="nk-tb-col">' +
								'<div class="user-card">' +
								'<div class="user-avatar bg-dim-primary d-none d-sm-flex">' +
								'<span><img src="' + product['img'] + '"></span>' +
								'</div>' +
								'<span>' + product["name"] + '</span>' +
								'</div>' +
								'</td>' +
								'<td class="nk-tb-col tb-col-mb">' +
								'<span>' + product["description"] + '</span>' +
								'</td>' +
								'<td class="nk-tb-col tb-col-mb">' +
								'<span>' + Date(product["created_at"]["seconds"] * 1000).slice(0, 25) +
								'</span>' +
								'</td>' +
								'<td class="nk-tb-col tb-col-md">' +
								'<div class="user-info">' +
								'<span class="tb-lead">' + product["price"] +
								' €<span class="dot dot-success d-md-none ml-1"></span></span>' +
								'<span></span>' +
								'</div>' +
								'</td>' +
								'<td class="nk-tb-col nk-tb-col-tools">' +
								'<ul class="nk-tb-actions gx-1">' +
								'<li class="nk-tb-action-hidden">' +
								'<a  class="btn btn-trigger btn-icon" onclick=deleteProduct("' +
								product['id'] +
								'"); data-toggle="tooltip" data-placement="top"' +
								'title="Suprimer">' +
								'<em class="icon ni ni-trash-alt"></em>' +
								'</a>' +
								'</li>' +
								'</ul>' +
								'</td>' +
								'</tr><!-- .nk-tb-item \'');
						});
					});
				$("#loader").attr("hidden", true);
				$("#block").removeAttr("hidden");
			});


		}
	</script>
@endsection
