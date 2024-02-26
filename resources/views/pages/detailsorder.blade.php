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
								<div class="row">
									<div class="col-md-4">
										<h4>Information</h4><br><br>
										<div class="row user-info text-left">
											<div class="col-md-12">
												<h5>Code de la commande : <span id="num_commande"></span>
												</h5>
											</div>
											<div style="margin-bottom: 60px"></div>
											<div class="col-md-12">
												<h5>Date de la commande : <span id="date_commande"></span></h5>
											</div>
											<div style="margin-bottom: 60px"></div>
											<div class="col-md-12">
												<h5>Adresse de livraison : <span id="adresse_livraison"></span></h5>
											</div>
											<div style="margin-bottom: 60px"></div>
											<div class="col-md-12">
												<h5>Crénaux de livraison : <span id="creneauxChoose_livraison"></span></h5>
											</div>
											<div style="margin-bottom: 60px"></div>
											<div class="col-md-12">
												<h5>Type de livraison : <span id="type_livraison"></span></h5>
											</div>
											<div style="margin-bottom: 60px"></div>
											<div class="col-md-12">
												<h5>Type de paiement : <span id="payment_type"></span></h5>
											</div>
											<div style="margin-bottom: 60px"></div>
											<div class="col-md-12">
												<h5>Note du client : <span id="customer_note"></span></h5>
											</div>
											<div style="margin-bottom: 60px"></div>
											<h4>Information sur le client</h4>
											<div style="margin-bottom: 60px"></div>
											<div class="col-md-12">
												<h5>Nom : <span id="nom"></span></h5>
											</div>
											<div style="margin-bottom: 60px"></div>
											<div class="col-md-12">
												<h5>Prénom : <span id="prenom"></span></h5>
											</div>
											<div style="margin-bottom: 60px"></div>
											<div class="col-md-12">
												<h5>Téléphone : <span id="phone"></span>
												</h5>
											</div>
											<div style="margin-bottom: 60px"></div>
											<div class="col-md-12">
												<h5>Email : <span id="email"></span>
												</h5>
											</div>
										</div>
									</div>
									<div class="col-md-8" style="border-left: 1px solid rgb(218, 212, 212)">
										<h4>Commande</h4><br><br>
										<div class="table-responsive">

											<table class="table">
												<thead>
													<tr>
														<th scope="col">Image</th>
														<th scope="col">Nom</th>
														<th scope="col">Catégorie</th>
														<th scope="col">Prix unitaire</th>
														<th scope="col">Qunatité</th>
														<th scope="col">Prix total</th>
													</tr>
												</thead>
												<tbody id="order-table">

												</tbody>
											</table>
										</div>
										<div class="row user-info text-left">

											<div class="col-md-12">
												<h5>Sous total : <span id="subtotal"></span>
												</h5>
											</div>
											<div style="margin-bottom: 40px"></div>
											<div class="col-md-12">
												<h5>TVA : <span id="tva"></span></h5>
											</div>
											<div style="margin-bottom: 40px"></div>
											<div class="col-md-12">
												<h5>Livraison TTC : <span id="livraison"></span></h5>
											</div>
											<div style="margin-bottom: 40px"></div>
											<div class="col-md-12">
												<h5>Total : <span id="total"></span></h5>
											</div>

										</div>
									</div>
								</div>

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
			getOrders('{{ $id }}');
			$("#loader").attr("hidden", true);
			$("#block").removeAttr("hidden");
		});

		function closeCommand(id) {
			// e.preventDefault();
			console.log(id);
			var database = firebase.firestore();
			database.collection('order').doc(id).update({
				status: "CLOSED",
			}).then(() => {
				console.log("Document updated"); // Document updated
				location.reload();
			});
		}

		function pendingCommand(id) {
			// e.preventDefault();
			console.log(id);
			var database = firebase.firestore();
			database.collection('order').doc(id).update({
				status: "PENDING",
			}).then(() => {
				console.log("Document updated"); // Document updated
				location.reload();
			});
		}

		function cancelledCommand(id) {
			// e.preventDefault();
			console.log(id);
			var database = firebase.firestore();
			database.collection('order').doc(id).update({
				status: "CANCELLED",
			}).then(() => {
				console.log("Document updated"); // Document updated
				location.reload();
			});
		}

		function getOrders(id) {
			var database = firebase.firestore();
			var ref = database.collection('order').doc('{{ $id }}').get().then((doc) => {
				console.log(doc.data()['items']);
				$("#num_commande").text(doc.data()['id']);

				$("#tva").text(doc.data()['tax_amount'].toFixed(2) + ' €');
				$("#total").text(doc.data()['total'].toFixed(2) + ' €');
				$("#subtotal").text(doc.data()['subtotal'].toFixed(2) + ' €');
				$("#livraison").text(doc.data()['shipping_amount'].toFixed(2) + ' €');
				$("#adresse_livraison").text(doc.data()['shipping_address']);
				$("#type_livraison").text(doc.data()['shipping_type']);
				$("#nom").text(doc.data()['first_name']);
				$("#prenom").text(doc.data()['last_name']);
				$("#phone").text(doc.data()['phone']);
				$("#payment_type").text(doc.data()['payment_type']);
				$("#customer_note").text(doc.data()['customer_note'] != "" ? doc.data()['customer_note'] : "Aucune");
				$("#email").text(doc.data()['email'] != "" ? doc.data()['email'] : "Aucune");

				$("#date_commande").text(Date(doc.data()["created_at"] * 1000).slice(0, 25));
				$("#creneauxChoose_livraison").text(Date(doc.data()["creneauxChoose"] * 1000).slice(0, 25));
				$("#order-table").html("");
				$.each(Object.entries(doc.data()['items']), function(key, value) {
					// Convertir la chaîne JSON en objet JavaScript
					var item = JSON.parse(value[1]);

					// Créer une nouvelle ligne HTML avec les valeurs de l'objet
					var newRow = '<tr>' +
						'<td><img src="' + item.image + '" style="width: 75px;"></td>' +
						'<td>' + item.name + '</td>' +
						'<td>' + item.categorie + '</td>' +
						'<td>' + item.price.toFixed(2) + ' €' + '</td>' +
						'<td>' + item.qantity + '</td>' +
						'<td>' + item.totalammount.toFixed(2) + ' €' + '</td>' +
						'</tr>';

					// Ajouter la nouvelle ligne à la table
					$("#order-table").append(newRow);
				});
			});
			return true;
		}
	</script>
@endsection
