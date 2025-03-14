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
	<?php
	include 'koneksi.php';

	$norm = $_GET["norm"];
	$kode = $_GET['kd_kunjungan'];

	$est_dilayani = ibase_query($dbh, "SELECT FIRST 1 EST_DILAYANI, NO_ANTRIAN, ID_ANTRIAN FROM TH_ANTRIAN WHERE NORM = '$norm' ORDER BY TGL_ANTRIAN DESC");
	$est_dilayani = ibase_fetch_object($est_dilayani);

	$kunjungan = ibase_query($dbh, "SELECT B.NAMA_PENJAMIN, C.TEMPAT_LAYANAN, D.NAMA FROM TH_KUNJUNGAN A
	JOIN RH_PENJAMIN B ON A.PENJAMIN = B.ID
	JOIN MH_TEMPATLAYANAN C ON A.TMP_LAYANAN2 = C.ID
	JOIN MH_PROVIDER D ON A.DPJP = D.ID
	WHERE A.KODE ='$kode'");
	$kunjungan =ibase_fetch_object($kunjungan);


	// echo $kode1->KODE_RESERVASI;
	// echo "<br>";
	// echo $est_dilayani->EST_DILAYANI;
	// echo "<br>";
	// echo $est_dilayani->ID_ANTRIAN . $est_dilayani->NO_ANTRIAN;
	?>
	<div class="limiter" align= "center">
		<div class="container-login100" align= "center">
			<div class="wrap-login100"  align= "center">
				<label for="">
				<h1><b> RSU NATALIA </b></h1>
				<h1><b> KABUPATEN BOYOLALI </b></h1>
				<hr width="80%" align="center">
			</label>


				<label for="">
					<h2><b>TIKET ANTRIAN ANDA NOMOR</b> </h2><br>
					<h4><b><?php echo $est_dilayani->ID_ANTRIAN.$est_dilayani->NO_ANTRIAN; ?></b></h4>
				</label>

				<label for="">Penjamin:
						<?php
						echo $kunjungan->NAMA_PENJAMIN;
						 ?>
					 </label>

					 <label for="">Poli:
	 				<?php
	 				echo $kunjungan->TEMPAT_LAYANAN;
	 				 ?>
	 			 </label>

				 <label for="">Dokter:
 				<?php
 				echo $kunjungan->NAMA;
 				 ?>
 			 </label>

			 <span class="txt1 p-b-11">
				 <u>Estimasi Dilayani</u>
			 </span>
			 <div>
				 <p><u><?php echo $est_dilayani->EST_DILAYANI; ?></u></p>
			 </div>
			 <br>
			 <label class="satu">
				 Tiket Hanya Berlaku Pada Hari Dicetak<br>
				 Terimakasih Atas Kunjungan Anda
			 </label>






        <form class="" action="cetak.php" method="get">
					<input type="hidden" name="norm" value="<?php echo $norm; ?>">
				 <input type="hidden" name="antrian" value="<?php echo $est_dilayani->ID_ANTRIAN . $est_dilayani->NO_ANTRIAN; ?>">
				 <input type="hidden" name="pj" value="<?php echo $kunjungan->NAMA_PENJAMIN; ?>">
				 <input type="hidden" name="poli" value="<?php echo $kunjungan->TEMPAT_LAYANAN; ?>">
				 <input type="hidden" name="dr" value="<?php echo $kunjungan->NAMA; ?>">
				 <input type="hidden" name="est" value="<?php echo $est_dilayani->EST_DILAYANI; ?>">

                <div align="right" class="button">
                  <button class="login100-form-btn" name="CETAK" style="margin: 10px;">CETAK TIKET</button>
                </div>
              </form>

			</div>
		</div>
	</div>


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
