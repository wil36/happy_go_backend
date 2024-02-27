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
													<th class="nk-tb-col tb-col-mb" width="30%"><span class="sub-text">Téléphone</span></th>
													<th class="nk-tb-col tb-col-md"><span class="sub-text">Model de voiture</span></th>
													<th class="nk-tb-col tb-col-lg"><span class="sub-text">Role</span></th>
													<th class="nk-tb-col tb-col-lg"><span class="sub-text">Status</span></th>
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

		function validerUnChauffeur(id) {
			Swal.fire({
				title: 'Voulez-vous vraiment valider ce chauffeur ?',
				text: "Vous êtes en train de vouloir valider ce chauffeur ! Assurez-vous que c'est bien le bon !",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Oui, c\'est le bon',
				cancelButtonText: 'Annuler',
			}).then((result) => {
				if (result.value) {
					var database = firebase.firestore();
					database.collection('users').doc(id).update({
						'status': true,
					}).then(() => {
						database.collection('users').doc(id).get().then((doc) => {
							if (doc.exists) {
								console.log('Document data:', doc.data()['fcmToken']);


								// Données supplémentaires à inclure dans la requête AJAX
								var additionalData = {
									token_user: doc.data()['fcmToken'],
									title: 'Compte activer',
									body: 'Votre compte chauffeur a bien été activer. Cliquez ici pour ouvrir l\'application',
									type: 'GET',
								};

								// Combiner les données du document avec les données supplémentaires
								var requestData = $.extend({}, doc.data(), additionalData);

								// Envoyer les données via une requête AJAX avec jQuery
								$.ajax({
									url: "{{ route('chauffeur.send_push') }}",
									type: 'GET',
									contentType: 'application/json',
									data: requestData,
									success: function(response) {
										console.log('Réponse de la requête AJAX:',
											response);
										Swal.fire("Succès !",
											'Votre requête s\'est terminer avec succèss',
											'success', );

										location.reload();
										console.log("Document updated");
									},
									error: function(xhr, status, error) {
										console.error('Erreur lors de la requête AJAX:',
											error);
									}
								});
							} else {
								console.log('Aucun document trouvé');
							}
						}).catch((error) => {
							console.error('Erreur lors de la récupération du document:', error);
						});
					});
					// Document updated
				}
			});

		}

		// function downloadZip(user_id) {
		// 	var database = firebase.firestore();
		// 	var ref = database.collection('users').doc(user_id).get().then((doc) => {
		// 		if (doc.exists) {
		// 			// create a new zip file
		// 			var zip = new JSZip();
		// 			// add the file to the zip
		// 			zip.file(file.name, file.data, {
		// 				base64: true
		// 			});
		// 			// generate the zip file as a Blob
		// 			zip.generateAsync({
		// 					type: "blob"
		// 				})
		// 				.then(function(content) {
		// 					// create a download link for the zip file
		// 					var link = document.createElement("a");
		// 					link.href = URL.createObjectURL(content);
		// 					link.download = doc.data()["nom"] + "_" + doc.data()["prenom"] + ".zip";
		// 					// trigger the download
		// 					link.click();
		// 					// clean up the download link
		// 					URL.revokeObjectURL(link.href);
		// 				});
		// 		} else {
		// 			console.log("No such document!");
		// 		}
		// 	}).catch((error) => {
		// 		console.log("Error getting document:", error);
		// 	});

		// }

		function downloadFileFromFirestorage(fileUrl) {
			// Replace 'your-storage-bucket' with your actual Firebase Storage bucket name
			var storageRef = firebase.storage().refFromURL(fileUrl);

			return storageRef.getDownloadURL().then(url => {
				return fetch(url).then(response => {
					return response.blob();
				}).then(blob => {
					return new Promise((resolve, reject) => {
						var reader = new FileReader();
						reader.onload = () => {
							resolve(reader.result.split(',')[1]);
						};
						reader.readAsDataURL(blob);
					});
				});
			});
		}

		function downloadZip(user_id) {
			var database = firebase.firestore();
			var ref = database.collection('users').doc(user_id).get().then((doc) => {
				if (doc.exists) {
					// create a new zip file
					var zip = new JSZip();

					// Array of fields containing file URLs
					var urlFields = ['backCniPicture', 'driverCardPicture',
						'frontCniPicture', 'assurancesPictures', 'carPictures'
					]; // replace with the actual field names

					// Add files from Firebase Storage to the zip
					var promises = [];
					urlFields.forEach(field => {
						var fileUrls = doc.data()[field];
						if (fileUrls && Array.isArray(fileUrls)) {
							fileUrls.forEach(fileUrl => {
								promises.push(downloadFileFromFirestorage(fileUrl).then(
									base64String => {
										var fileName = getFileNameFromURL(
											fileUrl
										); // replace with a function to get file name from URL
										zip.file(fileName, base64String, {
											base64: true
										});
									}));
							});
						} else {
							promises.push(downloadFileFromFirestorage(fileUrls).then(
								base64String => {
									var fileName = getFileNameFromURL(
										fileUrls
									); // replace with a function to get file name from URL
									zip.file(fileName, base64String, {
										base64: true
									});
								}));
						}
					});

					// Wait for all files to be added to the zip
					Promise.all(promises).then(() => {
						// generate the zip file as a Blob
						console.log("All files added to the zip");
						zip.generateAsync({
								type: "blob"
							})
							.then(function(content) {
								// create a download link for the zip file
								var link = document.createElement("a");
								link.href = URL.createObjectURL(content);
								link.download = doc.data()["nom"] + "_" + doc.data()["prenom"] + ".zip";
								// trigger the download
								link.click();
								// clean up the download link
								URL.revokeObjectURL(link.href);
							});
					});
				} else {
					console.log("No such document!");
				}
			}).catch((error) => {
				console.log("Error getting document:", error);
			});
		}

		function getFileNameFromURL(fileUrl) {
			var urlParts = fileUrl.split('/');
			return urlParts[urlParts.length - 1];
		}

		function getproducts() {
			var database = firebase.firestore();
			var ref = database.collection('users').where("status", "==", false).where("role", "==", "Drivers").limit(500)
				.get().then((querySnapshot) => {
					console.log(querySnapshot);
					if (querySnapshot.empty == false) {

						$("#loader").attr("hidden", true);
						$("#block").removeAttr("hidden");
						console.log(querySnapshot);
						$("#products-list").html('');
						querySnapshot.forEach((doc) => {
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
								'<span><img src="' + doc.data()['profileUrl'] + '"></span>' +
								'</div>' +
								'<span>' + doc.data()["nom"] + ' ' + doc.data()["prenom"] + '</span>' +
								'</div>' +
								'</td>' +
								'<td class="nk-tb-col tb-col-mb">' +
								'<span>' + doc.data()["phone"] + '</span>' +
								'</td>' +
								'<td class="nk-tb-col tb-col-mb">' +
								'<span>' + doc.data()["carmodel"] + '</span>' +
								'</td>' +
								// '<td class="nk-tb-col tb-col-mb">' +
								// '<span>' + Date(doc.data()["created_at"] * 1000).slice(0, 25) + '</span>' +
								// '</td>' +
								'<td class="nk-tb-col tb-col-md">' +
								'<div class="user-info">' +
								'<span class="tb-lead">' + doc.data()["role"] +
								'<span class="dot dot-success d-md-none ml-1"></span></span>' +
								'<span></span>' +
								'</div>' +
								'</td>' +
								'<td class="nk-tb-col tb-col-mb">' +
								'<span class="badge badge-outline-warning">Non valide</span>' +
								'</td>' +
								'<td class="nk-tb-col nk-tb-col-tools">' +
								'<ul class="nk-tb-actions gx-1">' +
								'<li class="nk-tb-action-hidden">' +
								'<a onclick=downloadZip("' + doc.data()["uid"] +
								'"); class="btn btn-trigger btn-icon" data-toggle="tooltip" data-placement="top"' +
								'title="Télécharger le dossier du chauffeur">' +
								'<em class="icon ni ni-download"></em>' +
								'</a>' +
								'</li>' +
								'<li class="nk-tb-action-hidden">' +
								'<a  class="btn btn-trigger btn-icon" onclick=validerUnChauffeur("' + doc.id +
								'"); data-toggle="tooltip" data-placement="top"' +
								'title="Valider le chauffeur">' +
								'<em class="icon ni ni-check-c"></em>' +
								'</a>' +
								'</li>' +
								'</ul>' +
								'</td>' +
								'</tr><!-- .nk-tb-item \'');
						});
					} else {
						$("#loader").attr("hidden", true);
						$("#block").removeAttr("hidden");
						console.log(querySnapshot);
						$("#products-list").html('');
						$("#products-list").append(
							'<tr><div class="d-flex justify-content-center">Pas de chauffeur</div></tr>'
						);
					}
				});


		}
	</script>
@endsection
