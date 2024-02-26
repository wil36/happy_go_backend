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
									<a href="{{ route('category.create') }}" class="btn btn-primary" id="export-pending">Ajouter une catégorie</a>
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
													<th class="nk-tb-col tb-col-mb"><span class="sub-text">Nom</span></th>
													<th class="nk-tb-col tb-col-md"><span class="sub-text">Date de création</span></th>
													<th class="nk-tb-col tb-col-lg"><span class="sub-text">Nombre de produits</span></th>
													<th class="nk-tb-col nk-tb-col-tools text-right">Action
													</th>
												</tr>
											</thead>
											<tbody id="categories-list">
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
			getCategories();
		});

		function deleteCategory(id) {
			// e.preventDefault();

			Swal.fire({
				title: 'Voulez-vous vraiment supprimer cette catégorie ?',
				text: "Vous êtes en train de vouloir supprimer cette catégorie ! Assurez-vous que c'est bien la bonnne !",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Oui',
				cancelButtonText: 'Annuler',
			}).then((result) => {
				if (result.value) {
					var database = firebase.firestore();
					database.collection('category').doc(id).delete().then(() => {
						Swal.fire("Succès !",
							'Votre requête s\'est terminer avec succèss',
							'success', );
						location.reload();
					});

				}
			});
		}

		function getCategories() {
			var database = firebase.firestore();
			var ref = database.collection('category').limit(500).orderBy("created_time", "desc").get().then((
				querySnapshot) => {
				console.log(querySnapshot);
				if (querySnapshot.empty == false) {
					$("#loader").attr("hidden", true);
					$("#block").removeAttr("hidden");
					$("#categories-list").html('');
					querySnapshot.forEach((doc) => {
						let routeEdit = "{{ route('category.edit', '') }}/" +
							doc.id;
						let routeListProducts = "{{ route('category.listProducts', '') }}/" +
							doc.id;
						$("#categories-list").append('\'<tr class="nk-tb-item">' +
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
							'<span>' + Date(doc.data()["created_time"] * 1000).slice(0, 25) + '</span>' +
							'</td>' +
							'<td class="nk-tb-col tb-col-md">' +
							'<div class="user-info">' +
							'<span class="tb-lead">' + doc.data()["productsList"].length +
							' <span class="dot dot-success d-md-none ml-1"></span></span>' +
							'<span></span>' +
							'</div>' +
							'</td>' +
							'<td class="nk-tb-col nk-tb-col-tools">' +
							'<ul class="nk-tb-actions gx-1">' +
							'<li class="nk-tb-action-hidden">' +
							'<a href=" ' + routeListProducts +
							'" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top"' +
							'title="Liste des produits">' +
							'<em class="icon ni ni-list-index-fill"></em>' +
							'</a>' +
							'</li>' +
							'<li class="nk-tb-action-hidden">' +
							'<a href=" ' + routeEdit +
							'" class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top"' +
							'title="modifier">' +
							'<em class="icon ni ni-pen"></em>' +
							'</a>' +
							'</li>' +
							'<li class="nk-tb-action-hidden">' +
							'<a  class="btn btn-trigger btn-icon" onclick=deleteCategory("' + doc.id +
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
