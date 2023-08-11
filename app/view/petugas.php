<?php include '../../config/autoloads.php';?>
<?php
if(isset($rowAkses)) {
	$getAkses = json_decode($rowAkses['akses'], true);
	checkAccessUser('petugas', $getAkses);
	checkMaintenance($rowAkses, $rowUmum);
}
?>
<?php
$id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
$query = mysqli_query($conn, "SELECT * FROM m_petugas WHERE id = '$id'");
$row = allRowValidateHTML(mysqli_fetch_array($query, MYSQLI_ASSOC));
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "../layout/head.php";?>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-footer-fixed layout-navbar-fixed">
	<div class="wrapper">
		<div class="preloader flex-column justify-content-center align-items-center">
			<img class="animation__shake" src="<?= pathToFile('assets/img/logo/'.$dataSEO['logo'].'');?>" alt="<?= $rowSeo['nama_website'];?> Logo" height="60" width="60">
		</div>

		<nav class="main-header navbar navbar-expand navbar-white navbar-light">
			<?php include "../layout/navbar.php";?>
		</nav>

		<aside class="main-sidebar sidebar-dark-primary elevation-4">
			<?php include "../layout/aside.php";?>
		</aside>

		<div class="content-wrapper">
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Detail Petugas</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="../../beranda">Beranda</a></li>
								<li class="breadcrumb-item"><a href="../../petugas">Petugas</a></li>
								<li class="breadcrumb-item active">Detail Petugas</li>
							</ol>
						</div>
					</div>
				</div>
			</section>
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card card-primary card-outline loading-card">
								<div class="card-header">
									<h3 class="card-title margin-top-five">
										<a href="../../petugas" alt="Kembali" class="btn btn-sm btn-danger">
											<i class="fas fa-arrow-left fa-sm"></i>&nbsp; Kembali
										</a>
									</h3>
								</div>
								<?php if(issetEmpty($row)) { ?>
									<div class="card-body">
										<form role="form" action="#" method="POST" enctype="multipart/form-data" id="data-form">
											<input type="hidden" name="id" value="<?= $row['id'];?>">
											<div class="row">
												<div class="col-lg-6 col-md-12">
													<div class="form-group">
														<label for="nama">Nama Petugas</label>
														<input type="text" name="nama" id="nama" class="form-control" autocomplete="off" placeholder="Masukkan Nama Petugas" disabled="" minlength="1" maxlength="100" value="<?= $row['nama'];?>">
													</div>
												</div>
												<div class="col-lg-6 col-md-12">
													<div class="form-group">
														<label for="jenis_kelamin">Jenis Kelamin</label>
														<select class="form-control select2" name="jenis_kelamin" id="jenis_kelamin" disabled="">
															<option value="">Pilih Jenis Kelamin</option>
															<option value="Laki - Laki" <?= isSelected($row['jenis_kelamin'], "Laki - Laki");?>>Laki - Laki</option>
															<option value="Perempuan" <?= isSelected($row['jenis_kelamin'], "Perempuan");?>>Perempuan</option>
														</select>
													</div>
												</div>
												<div class="col-lg-6 col-md-12">
													<div class="form-group">
														<label for="tempat_lahir">Tempat Lahir</label>
														<input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" autocomplete="off" placeholder="Masukkan Tempat Lahir" disabled="" minlength="1" maxlength="100" value="<?= $row['tempat_lahir'];?>">
													</div>
												</div>
												<div class="col-lg-6 col-md-12">
													<div class="form-group">
														<label for="tanggal_lahir">Tanggal Lahir</label>
														<input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" autocomplete="off" placeholder="Masukkan Tanggal Lahir" disabled="" value="<?= $row['tanggal_lahir'];?>">
													</div>
												</div>
												<div class="col-lg-4 col-md-12">
													<div class="form-group">
														<label for="telepon">Telepon</label>
														<input type="text" name="telepon" id="telepon" class="form-control phone-number" autocomplete="off" placeholder="Masukkan Telepon" minlength="1" maxlength="15" disabled="" value="<?= $row['telepon'];?>">
													</div>
												</div>
												<div class="col-lg-4 col-md-12">
													<div class="form-group">
														<label for="email">E-mail</label>
														<input type="email" name="email" id="email" class="form-control" autocomplete="off" placeholder="Masukkan E-mail" minlength="1" maxlength="100" disabled="" value="<?= $row['email'];?>">
													</div>
												</div>
												<div class="col-lg-4 col-md-12">
													<div class="form-group">
														<label for="password">Kata Sandi <small class="text-muted">(Opsional)</small></label>
														<input type="password" name="password" id="password" class="form-control" autocomplete="off" placeholder="Masukkan Kata Sandi" minlength="1" maxlength="20" disabled="" value="<?= $row['password'];?>">
													</div>
												</div>
												<div class="col-lg-6 col-md-12">
													<div class="form-group">
														<label for="alamat">Alamat <i title="Drag icon yang ada di peta jika ingin mengubah alamat" class='fas fa-exclamation-circle' style='cursor: pointer;'></i></label>
														<input type="text" name="alamat" id="alamat" class="form-control" autocomplete="off" placeholder="Masukkan Alamat" disabled="" minlength="1" value="<?= $row['alamat'];?>" readonly="">
														<input type="hidden" name="place_id" id="place_id" class="form-control" autocomplete="off" value="<?= $row['place_id'];?>">
													</div>
												</div>
												<div class="col-lg-3 col-md-12">
													<div class="form-group">
														<label for="latitude">Latitude</label>
														<input type="text" name="latitude" id="latitude" class="form-control" autocomplete="off" placeholder="Masukkan Latitude" disabled="" value="<?= $row['latitude'];?>">
													</div>
												</div>
												<div class="col-lg-3 col-md-12">
													<div class="form-group">
														<label for="longitude">Longitude</label>
														<input type="text" name="longitude" id="longitude" class="form-control" autocomplete="off" placeholder="Masukkan Longitude" disabled="" value="<?= $row['longitude'];?>">
													</div>
												</div>
												<div class="col-lg-12 col-md-12">
													<div class="form-group">
														<div id="simple-map" style="height: 400px;"></div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-3 col-md-12">
													<div class="form-group">
														<label for="avatar">Avatar <small class="text-muted">(Opsional)</small></label>
														<div id="image-preview" class="image-preview" style="background-image: url('../../../assets/img/avatar/<?= $row['avatar'];?>'); background-size: cover; background-position: center center;"></div>
													</div>
												</div>
											</div>
										</form>
									</div>
								<?php }else { ?>
									<div class="card-body">
										<div class="error-page">
											<h2 class="headline text-warning"> 404</h2>
											<div class="error-content">
												<h3>
													<i class="fas fa-exclamation-triangle text-warning"></i> Oops! Data tidak dapat ditemukan
												</h3>
												<p>Maaf kami tidak dapat menemukan data apa pun, untuk menghilangkan pesan ini, buat setidaknya 1 data.</p>
												<form class="search-form">
													<a href="../../add/petugas" class="btn btn-primary mt-4">Buat Baru</a>
												</form>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>

		<footer class="main-footer">
			<?php include "../layout/footer.php";?>
		</footer>

		<aside class="control-sidebar control-sidebar-dark"></aside>
	</div>
	<?php include "../layout/script.php";?>

	<!-- JS Manual -->
	<script type="text/javascript">
		function updateMarkerPosition(latLng) {
			document.getElementById('latitude').value = [latLng.lat()]
			document.getElementById('longitude').value = [latLng.lng()]
		}

		function initMap() {
			var latitude_ = $('#latitude').val();
			var longitude_ = $('#longitude').val();

			if(typeof latitude_ != "undefined" && typeof longitude_ != "undefined" && latitude_ != "" && longitude_ != "" && latitude_ != "-" && longitude_ != "-") {
				defaultLatLong = {
					lat: parseFloat(latitude_),
					lng: parseFloat(longitude_)
				};
			} else {
				defaultLatLong = {
					lat: 40.7127753,
					lng: -74.0059728
				};
			}

			var map = new google.maps.Map(document.getElementById('simple-map'), {
				center: defaultLatLong,
				zoom: 15,
				mapTypeId: "roadmap",
				panControl: true,
				zoomControl: true,
				mapTypeControl: true,
				scaleControl: true,
				streetViewControl: true,
				overviewMapControl: true,
				rotateControl: true,
				fullscreenControl: true
			});

			var input = document.getElementById('alamat');
			var autocomplete = new google.maps.places.Autocomplete(input);

			autocomplete.bindTo('bounds', map);

			var marker = new google.maps.Marker({
				map: map,
				position: defaultLatLong,
				draggable: false,
				clickable: true
			});

			if( (typeof latitude_ == "undefined" && typeof longitude_ == "undefined") || (latitude_ == "" && longitude_ == "") || (latitude_ == "-" && longitude_ == "-") ) {
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(function(position) {
						initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
						map.setCenter(initialLocation);
						marker.setPosition(initialLocation);

						var geocoder = new google.maps.Geocoder;

						latitude = position.coords.latitude;
						longitude = position.coords.longitude
						var latlng = {lat: parseFloat(latitude), lng: parseFloat(longitude)};

						geocoder.geocode({'location': latlng}, function(results, status) {
							if (status === google.maps.GeocoderStatus.OK) {
								if (results[0]) {
									$('#place_id').val(results[0].place_id);
									$('#alamat').val(results[0].formatted_address);
								} else {
									swal('Peringatan', 'Alamat tidak ditemukan', 'error');
								}
							} else {
								swal('Peringatan', 'Gagal mendapatkan geocoder: ' + status, 'error');
							}
						});

						$('#latitude').val(position.coords.latitude);
						$('#longitude').val(position.coords.longitude);
					});
				}
			}

			google.maps.event.addListener(marker, 'dragend', function(marker) {
				updateMarkerPosition(marker.latLng);
				var latLng = marker.latLng;
				currentLatitude = latLng.lat();
				currentLongitude = latLng.lng();
				var latlng = {
					lat: currentLatitude,
					lng: currentLongitude
				};
				var geocoder = new google.maps.Geocoder;
				geocoder.geocode({
					'location': latlng
				}, function(results, status) {
					if (status === 'OK') {
						if (results[0]) {
							$('#place_id').val(results[0].place_id);
							input.value = results[0].formatted_address;
						} else {
							swal('Peringatan', 'Alamat tidak ditemukan', 'error');
						}
					} else {
						swal('Peringatan', 'Gagal mendapatkan geocoder: ' + status, 'error');
					}
				});
			});

			autocomplete.addListener('place_changed', function() {
				var place = autocomplete.getPlace();
				if (!place.geometry) {
					return;
				}
				if (place.geometry.viewport) {
					map.fitBounds(place.geometry.viewport);
				} else {
					map.setCenter(place.geometry.location);
				}

				marker.setPosition(place.geometry.location);

				updateMarkerPosition(place.geometry.location);

				$('#place_id').val(place.place_id);

				currentLatitude = place.geometry.location.lat();
				currentLongitude = place.geometry.location.lng();
			});
		}
	</script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA1MgLuZuyqR_OGY3ob3M52N46TDBRI_9k&libraries=places&callback=initMap&sensor=false"></script>
</body>
</html>