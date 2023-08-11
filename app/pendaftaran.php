<?php include '../config/autoloads.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
	<meta content="<?= $dataSEO['description'];?>" name="description">
	<meta content="<?= $dataSEO['keyword'];?>" name="keywords">
	<meta content="<?= $dataSEO['author'];?>" name="author">
	<meta content="<?= $dataSEO['robots'];?>" name="robots">
	<meta content="article" property="og:type">
	<meta content="<?= $dataSEO['url'];?>" property="og:url">
	<meta content="<?= $dataSEO['title'];?>" property="og:title">
	<meta content="<?= $dataSEO['url'];?>assets/img/logo/<?= $dataSEO['logo'];?>" property="og:image">
	<meta content="image/jpeg" property="og:image:type">
	<meta content="<?= $dataSEO['title'];?>" property="og:image:alt">
	<meta content="<?= $dataSEO['title'];?>" property="og:image:title">
	<meta content="800" property="og:image:width">
	<meta content="800" property="og:image:height">
	<meta content="<?= $dataSEO['description'];?>" property="og:description">
	<meta content="summary_large_image" name="twitter:card">
	<meta content="<?= $dataSEO['description'];?>" name="twitter:description">
	<meta content="<?= $dataSEO['url'];?>assets/img/logo/<?= $dataSEO['logo'];?>" name="twitter:image">
	<meta content="<?= $dataSEO['url'];?>assets/img/logo/<?= $dataSEO['logo'];?>" name="twitter:image:src">
	<meta content="<?= $dataSEO['title'];?>" name="twitter:title">
	<title><?= $dataSEO['title'];?></title>
	<link href="<?= $dataSEO['url'];?>assets/img/logo/<?= $dataSEO['logo'];?>" rel="image_src">
	<link href="<?= $dataSEO['url'];?>" rel="canonical">
	<link rel="shortcut icon" type="image/x-icon" sizes="96x96" href="<?= pathToFile('assets/img/logo/'.$dataSEO['logo']);?>">
	<!-- General CSS Files -->
	<link rel="stylesheet" href="<?= clearCacheFile(pathToFile('assets/fonts/sourcesanspro.css'));?>">
	<!-- CSS Libraries -->
	<link rel="stylesheet" href="<?= clearCacheFile(pathToFile('vendor/fontawesome-free/css/all.min.css'));?>">
	<link rel="stylesheet" href="<?= clearCacheFile(pathToFile('vendor/icheck-bootstrap/icheck-bootstrap.min.css'));?>">
	<link rel="stylesheet" href="<?= clearCacheFile(pathToFile('vendor/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'));?>">
	<link rel="stylesheet" href="<?= clearCacheFile(pathToFile('vendor/toastr/toastr.min.css'));?>">
	<!-- Template CSS -->
	<link rel="stylesheet" href="<?= clearCacheFile(pathToFile('assets/css/adminlte.min.css'));?>">
	<link rel="stylesheet" href="<?= clearCacheFile(pathToFile('assets/css/custom.css'));?>">
</head>
<body class="hold-transition login-page">
	<div class="login-box">
		<div class="card card-outline card-primary loading-card">
			<div class="card-header text-center">
				<a href="<?= getBaseURL() . "app/";?>" class="h1">
					<img src="../assets/img/logo/<?= $dataSEO['logo'];?>" alt="logo" width="120">
				</a>
			</div>
			<div class="card-body">
				<p class="login-box-msg">Lakukan pendaftaran untuk dapat mengakses menu <?= $rowSeo['nama_website'];?></p>
				<form role="form" action="#" method="POST" enctype="multipart/form-data" id="data-form">
					<div class="input-group mb-3">
						<input type="text" name="nama" id="nama" class="form-control" autocomplete="off" placeholder="Masukkan Nama" required="" minlength="1" maxlength="100" autofocus="">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-user"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="text" name="telepon" id="telepon" class="form-control phone-number" autocomplete="off" placeholder="Masukkan Telepon" required="" minlength="1" maxlength="15" autofocus="">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-phone"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="email" name="email" id="email" class="form-control" autocomplete="off" placeholder="Masukkan E-mail" required="" minlength="15" maxlength="100" autofocus="">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="password" name="password" id="password" class="form-control" autocomplete="off" placeholder="Masukkan Kata Sandi" required="" minlength="1" maxlength="20" autofocus="">
						<div class="input-group-append">
							<div class="input-group-text" style="cursor: pointer;" id="showPassword">
								<span class="fas fa-lock" id="iconShowPassword"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<button type="submit" class="btn btn-sm btn-primary btn-block btn-save">Daftar</button>
						</div>
					</div>
				</form>
				<p class="mt-3 mb-1">
					<a href="<?= getBaseURL() . "app/";?>">Masuk</a>
				</p>
			</div>
		</div>
	</div>
	
	<!-- JS Libraries -->
	<script src="<?= clearCacheFile(pathToFile('vendor/jquery/jquery.min.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/jquery-ui/jquery-ui.min.js'));?>"></script>
	<script>
		$.widget.bridge('uibutton', $.ui.button)
	</script>
	<script src="<?= clearCacheFile(pathToFile('vendor/bootstrap/js/bootstrap.bundle.min.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/sweetalert2/sweetalert2.min.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/toastr/toastr.min.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/cleave.js/dist/cleave.min.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/cleave.js/dist/addons/cleave-phone.us.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/cleave.js/dist/addons/cleave-phone.id.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/chart.js/Chart.min.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/sparklines/sparkline.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/jqvmap/jquery.vmap.min.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/jqvmap/maps/jquery.vmap.usa.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/jquery-knob/jquery.knob.min.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/moment/moment.min.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/daterangepicker/daterangepicker.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/summernote/summernote-bs4.min.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/datatables/jquery.dataTables.min.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/datatables-responsive/js/dataTables.responsive.min.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/datatables-responsive/js/responsive.bootstrap4.min.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/datatables-buttons/js/dataTables.buttons.min.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/datatables-buttons/js/buttons.bootstrap4.min.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/datatables-buttons/js/buttons.html5.min.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/datatables-buttons/js/buttons.print.min.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/datatables-buttons/js/buttons.colVis.min.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('vendor/select2/js/select2.full.min.js'));?>"></script>
	<!-- General JS Files -->
	<script src="<?= clearCacheFile(pathToFile('assets/js/adminlte.min.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('assets/js/custom.js'));?>"></script>
	<script src="<?= clearCacheFile(pathToFile('assets/js/app.js'));?>"></script>

	<!-- JS Manual -->
	<script type="text/javascript">
		var isShowPassword = false;

		$('#showPassword').on('click', function(e) {
			e.preventDefault();

			isShowPassword = !isShowPassword;

			if(isShowPassword == true) {
				$('#password').prop("type", "text");
				$('#iconShowPassword').removeClass('fas fa-lock');
				$('#iconShowPassword').addClass('fas fa-unlock');
			}else {
				$('#password').prop("type", "password");
				$('#iconShowPassword').removeClass('fas fa-unlock');
				$('#iconShowPassword').addClass('fas fa-lock');
			}
		});

		$("#data-form").submit(function(e) {
			e.preventDefault();

			var data = new FormData(this);
			data.append('function', 'signUpCustomer');

			$('button[type=submit]', this).attr('disabled', 'disabled');
			let save_button = $(this).find('.btn-save'),
			that = this,
			card = $('.loading-card');

			let card_progress = $.cardProgress(card, {
				spinner: false
			});
			save_button.addClass('btn-progress');

			setTimeout(function() {
				card_progress.dismiss(function() {
					$('html, body').animate({
						scrollTop: 0
					});

					$.ajax({
						type: "POST",
						url: "../routes/web/site.php",
						data: data,
						processData: false,
						contentType: false,
						success: function(response) {
							var result = JSON.parse(response);
							if(result.status_code == 200) {
								toastr.success(result.message);
								setTimeout(() => {
									window.location.href = '<?= getBaseURL();?>' + 'app/';
								}, 1500);
							}else {
								toastr.error(result.message);
							}
							save_button.removeClass('btn-progress');
							$('button[type=submit]', that).removeAttr('disabled');
						}
					});
				});
			}, 1000);
			return false;
		});
	</script>
</body>
</html>