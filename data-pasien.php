<!DOCTYPE html>
<html lang="en">
<head>
	<title>Daftar Online RSU Natalia Boyolali</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<!--===============================================================================================-->
</head>

<body>
	<?php include "iklan.php"; ?>
	<?php
	include 'koneksi.php';
	if(isset($_GET["tampilkan"])){
		$tanggal = date('Y-m-d', strtotime( $_GET["tanggal"]));
		$date = date('Y-m-d H:i:s', strtotime( $_GET["tanggal"]));
		$hari = date('N', strtotime($tanggal));
		$waktu = $_GET["waktu"];


		$sql = ibase_query($dbh,"SELECT MH_TEMPATLAYANAN.TEMPAT_LAYANAN, MH_TEMPATLAYANAN.ID FROM MH_TEMPATLAYANAN
			JOIN TH_JADWAL ON TH_JADWAL.ID_TMPLAYANAN = MH_TEMPATLAYANAN.ID
			WHERE MH_TEMPATLAYANAN.TEMPAT_LAYANAN LIKE '%POLI%' AND TH_JADWAL.HARI = '$hari' GROUP BY MH_TEMPATLAYANAN.TEMPAT_LAYANAN, MH_TEMPATLAYANAN.ID ");
		}
		?>
<?php include "iklan.php"; ?>
		<div class="limiter">
			<div class="container-login100">
				<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
					<form class="login100-form validate-form flex-sb flex-w" action="poli.php" method="get">
						<input type="hidden" name="hari" id="hari" value="<?php echo $hari;?>">
						<input type="hidden" name="tanggal" id="tanggal" value="<?php echo $date;?>">
						<input type="hidden" name="waktu" value="<?php echo $waktu;?>">
						<span class="login100-form-title p-b-32">
							Data Pasien
						</span>

						<span class="txt1 p-b-11">
							Masukkan No CM Anda (No pada kartu Kontrol)
						</span>
						<div class="wrap-input100 validate-input m-b-36" data-validate = "Masukkan No CM Anda">
							<input type="text" name="norm" value="" id="norm" class="form-control" minlength="6" required>
							<span class="focus-input100"></span>
						</div>

						<span class="txt1 p-b-11">
							Masukkan Tanggal Lahir Anda
						</span>
						<div class="wrap-input100 validate-input m-b-36" data-validate = "Masukkan Tanggal Lahir Anda">
							<input type="date" name="tgl_lahir" value="" id="tgl_lahir" class="form-control" required>
							<span class="focus-input100"></span>
						</div>


						<div class="container-login100-form-btn">
							<button class="login100-form-btn" name="tampilkan">
								Lanjutkan
							</button>
						</div>

					</form>
				</div>
			</div>
		</div>

		<!--===============================================================================================-->

		<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script type="text/javascript">
		function isi_otomatis(){
			var norm = $("#norm").val();
			$.get("ajax-pasien.php?norm="+$("#norm").val(),function(data){
				var json = data,
				obj = JSON.parse(json);
				$('#nama').val(obj.nama);
			});
		};

		</script>

		<!--===============================================================================================-->
		<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
		<!--===============================================================================================-->
		<script src="vendor/animsition/js/animsition.min.js"></script>
		<!--===============================================================================================-->
		<script src="vendor/bootstrap/js/popper.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<!--===============================================================================================-->
		<script src="vendor/select2/select2.min.js"></script>
		<!--===============================================================================================-->
		<script src="vendor/daterangepicker/moment.min.js"></script>
		<script src="vendor/daterangepicker/daterangepicker.js"></script>
		<!--===============================================================================================-->
		<script src="vendor/countdowntime/countdowntime.js"></script>
		<!--===============================================================================================-->
		<script src="js/main.js"></script>

	</body>
	</html>
