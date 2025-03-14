
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
	<link rel="stylesheet" href="css/numpad.css">
	<!--===============================================================================================-->

	<style>
      select>option{
                   height:100px !important;

                 }
								 select{
									 font-size:40px;
								 }
								 option{
									 font-size:40px;
								 }
</style>
</head>

<body>

	<?php
	$dbh = mysqli_connect("112.78.43.162", "root", "12500103Lynx", "simrs_natalia");

// Check if the connection to the database is established
if (!$dbh) {
    die("Database connection failed: " . mysqli_connect_error());
}

	date_default_timezone_set('Asia/Jakarta');
	$year       = date('Y');
	$curr_month = date('m');
	$month      = date('Y-m');
	$date       = date('Y-m-d');
	// $date_time  = date('Y-m-d H:i:s');


		// $tanggal = date('Y-m-d', strtotime( $date));
		$date = date('Y-m-d H:i:s');
		// $hari = date('N', strtotime($tanggal));
		$time       = date('H:i:s');
		$waktu = date('H:i:s', strtotime( $time));

		if ($waktu <= '10:59:59' && $waktu >= '00:00:00') {
		  // code...
		  $w = '0';
		}
		elseif ($waktu >= '11:00:00' && $waktu <= '14:59:59') {
		  // code...
		  $w='1';
		}
		elseif ($waktu >= '15:00:00' && $waktu <= '23:59:59') {
		  // code...
		  $w='2';
		}
		else {
		  $w="tolol";
		}

		$kunjungan = $_GET['kunjungan'];
		$tanggal=date('Y-m-d', strtotime( $date));
        $tentukan_hari=date('D',strtotime($tanggal));
		 $day = array(
			'Sun' => 'AKHAD',
			'Mon' => 'SENIN',
			'Tue' => 'SELASA',
			'Wed' => 'RABU',
			'Thu' => 'KAMIS',
			'Fri' => 'JUMAT',
			'Sat' => 'SABTU'
			);
			$hari=$day[$tentukan_hari];

		?>

		<div class="limiter">
			<div class="container-login100">
				<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
					<form class="login100-form validate-form flex-sb flex-w" action="poli.php" method="get">
						<input type="hidden" name="hari" id="hari" value="<?php echo $hari;?>">
						<input type="hidden" name="tanggal" id="tanggal" value="<?php echo $date;?>">
						<input type="hidden" name="waktu" value="<?php echo $w;?>">
						<input type="hidden" name="tgl_kunjungan" value="<?php echo $date;?>">
						<input type="hidden" name="kunjungan" value="<?php echo $kunjungan; ?>">
						<span class="login100-form-title p-b-32" style="font-size: 50px; text-align:center;">
							Data Pasien
						</span>

						<span class="txt1 p-b-11" style="font-size: 20px; text-align:center;">
							Masukkan No CM Anda
							<br>
							 (No pada kartu Kontrol)
							 
							 / Kode Reservasi Anda
						</span>
						<!-- <div class="wrap-input100 validate-input m-b-36" data-validate = "Masukkan No CM Anda">
							<input type="text" name="norm" value="" id="norm" class="form-control" minlength="6" onclick="ini_numpad()" required>
							<span class="focus-input100"></span>
						</div> -->

						<div id="numPad">
							<input type="text" id="numDisplay" name="norm" autofocus>
							<div id="numBWrap">
								<div class="num" onclick="isi_norm(this)">7</div>
								<div class="num" onclick="isi_norm(this)">8</div>
								<div class="num" onclick="isi_norm(this)">9</div>
								<div class="del" onclick="hapus()">⤆</div>
								<div class="num" onclick="isi_norm(this)">4</div>
								<div class="num" onclick="isi_norm(this)">5</div>
								<div class="num" onclick="isi_norm(this)">6</div>
								<div class="clr" onclick="hapus_isi()">C</div>
								<div class="num" onclick="isi_norm(this)">1</div>
								<div class="num" onclick="isi_norm(this)">2</div>
								<div class="num" onclick="isi_norm(this)">3</div>
								<button class="ok" name="tampilkan" style="font-size: 48px; color:white;">✔</button>
								<!-- <div class="ok" ></div> -->
								<!-- <div class="cx">✖</div> -->
								<div class="zero" onclick="isi_norm(this)">0</div>
							</div>
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

		function isi_norm(a){
			var norm = $("#numDisplay").val();
			norm += $(a).text();
			$("#numDisplay").val(norm);
			console.log($(a).text());
		}

		function hapus() {
			$("#numDisplay").val(
    function(index, value){
        return value.substr(0, value.length - 1);
			});
		}

		function hapus_isi(){
			$("#numDisplay").val('');
		}

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
		<script src="vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
		<!--===============================================================================================-->
		<script src="vendor/countdowntime/countdowntime.js"></script>
		<!--===============================================================================================-->
		<script src="js/main.js"></script>

		<script src="js/numpad.js" type="text/javascript"></script>
		<script>

    // window.addEventListener("load", () => {
    //   // (C1) BASIC NUMPAD
    //   numpad.attach({target: document.getElementById("norm")});
    // });
		//
    // function ini_numpad(){
    //   numpad.attach({target: document.getElementById("norm")});
    // }
    </script>

	</body>
	</html>
