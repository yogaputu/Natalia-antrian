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
	<link rel="stylesheet" href="sweetalert/sweetalert2.css">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
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
}	if(isset($_GET["tampilkan"])){
		// $tanggal = date('Y-m-d', strtotime( $_GET["tanggal"]));
		$date = date('Y-m-d H:i:s', strtotime( $_GET["tanggal"]));
		// $hari = $_GET["hari"];
		$waktu = $_GET["waktu"];
		$norm = $_GET["norm"];
		$kunjungan = $_GET['kunjungan'];
		$bulan = date('m');
		$tahun = date('y');

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

		// $tgl_lahir = date("Y-m-d", strtotime($_GET["tgl_lahir"]));


		if ($kunjungan == 1 || $kunjungan == 3) {
			$sql_reservasi = mysqli_query($dbh, "SELECT no_rkm_medis, nm_pasien ,alamat ,no_peserta FROM pasien WHERE no_rkm_medis LIKE '%$norm'");
		}else {
			$sql_reservasi = mysqli_query($dbh, "SELECT booking_registrasi.kd_poli, booking_registrasi.kd_dokter, booking_registrasi.kd_pj, booking_registrasi.no_rujukan, booking_registrasi.kd_booking, pasien.no_rkm_medis, pasien.nm_pasien ,pasien.alamat ,pasien.no_peserta, A.nm_dokter AS dokter FROM pasien
				left JOIN booking_registrasi ON pasien.no_rkm_medis = booking_registrasi.no_rkm_medis
				LEFT JOIN booking_periksa ON booking_periksa.no_booking = booking_registrasi.kd_booking
				LEFT JOIN dokter A ON A.kd_dokter = booking_registrasi.kd_dokter
				WHERE booking_periksa.no_rkm_medis = '$norm' AND CAST(booking_periksa.tanggal AS DATE) = '$tanggal'");
		}
		if ($ps = mysqli_fetch_assoc($sql_reservasi)) {
			$nocm = $ps['no_rkm_medis'];
			$nama = $ps['nm_pasien'];
			$alamat = $ps['alamat'];
			$kartu = $ps['no_peserta'];
			$poli = $ps['kd_poli'];
			$dokter = $ps['kd_dokter'];
			$penjamin = $ps['kd_pj'];
			$rujukan = $ps['no_rujukan'];
			$nama_dokter = $ps['dokter'];
			$reservasi = $ps['kd_booking'];
		}else {
			echo "data kosong";
			// echo "<script>alert('DATA TIDAK TERDAFTAR');window.location = 'index.php';</script>";
		}
		if ($kunjungan == "3") {
			$penjamin = 'BPJ';
		}



		$sql = mysqli_query($dbh,"SELECT poliklinik.nm_poli, poliklinik.kd_poli FROM poliklinik
			JOIN jadwal ON jadwal.kd_poli = poliklinik.kd_poli
			WHERE jadwal.hari_kerja = '$hari'
			GROUP BY poliklinik.kd_poli ");
		}
		?>
		<div class="limiter" style="width:100%;overflow: hidden">
			<div class="container-login100" style="width:100%;overflow: hidden">
				<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55" style="width:100%;overflow: hidden">
					<form class="login100-form validate-form flex-sb flex-w" action="validasi.php" method="get" style="width:100%;overflow: hidden">
						<span class="login100-form-title p-b-32" style="width:100%;overflow: hidden">
							Pilih Poli Tujuan
						</span>
							<span class="focus-input100"></span>
						<input type="hidden" name="hari" id="hari" value="<?php echo $hari;?>">
						<input type="hidden" name="tanggal" id="tanggal" value="<?php echo $date;?>">
						<input type="hidden" name="tgl_kunjungan" id="tgl_kunjungan" value="<?php echo $tanggal;?>">
						<input type="hidden" name="waktu" id="waktu" value="<?php echo $waktu;?>">
						<input type="hidden" name="norm" value="<?php echo $nocm; ?>">
						<input type="hidden" name="kartu" value="<?php echo $kartu; ?>" id="kartu">
						<input type="hidden" name="tgl_rujukan" value="" id="tgl_rujukan">
						<input type="hidden" name="kunjungan" value="<?php echo $kunjungan; ?>">
						<input type="hidden" name="reservasi" value="<?php echo $reservasi; ?>">

						<span class="txt1 p-b-11">
							No. CM
						</span>
						<div class="wrap-input100 validate-input m-b-12">
							<input type="text" name="nocm" value="<?php echo $nocm; ?>" class="form-control" minlength="6" disabled>
						</div>

						<span class="txt1 p-b-11">
							Nama
						</span>
						<div class="wrap-input100 validate-input m-b-12">
							<input type="text" name="nama" value="<?php echo $nama; ?>" class="form-control" minlength="6" disabled>
						</div>

						<span class="txt1 p-b-11">
							Alamat
						</span>
						<div class="wrap-input100 validate-input m-b-12">
							<input type="text" name="alamat" value="<?php echo $alamat; ?>" class="form-control" minlength="6" disabled>
						</div>


						<span class="txt1 p-b-11">
							Pilih Poliklinik
						</span>
						<div class="wrap-input100 validate-input m-b-12" >
							<select class="form-control custom-select" name="poli" id="poli" <?php echo ($poli != "") ? 'disabled' : ''; ?>>
								<option value="" style="height:100px !important;">Pilih Poli Tujuan</option>
								<?php while ($row = mysqli_fetch_array($sql)) {?>
									<option value="<?php echo $row['kd_poli'];?>" <?php echo ($row['kd_poli']== $poli) ? 'selected' : ''; ?>><?php echo $row['nm_poli']; ?></option>
									<?php
								}
								?>
							</select>
							<?php if ($poli != ""): ?>
								<input type="hidden" name="poli" value="<?php echo $poli; ?>">
							<?php endif; ?>
						</div>

						<span class="txt1 p-b-11">
							Pilih Dokter
						</span>
						<div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
							<select class="form-control custom-select" name="dokter" id="dokter"  <?php echo ($dokter != "") ? 'disabled' : ''; ?>>
								<?php if ($dokter != ""): ?>
									<option value="<?php echo $dokter; ?>"><?php echo $nama_dokter; ?></option>
								<?php endif; ?>
							</select>
							<?php if ($dokter != ""): ?>
								<input type="hidden" name="dokter" value="<?php echo $dokter; ?>">
							<?php endif; ?>
						</div>
						<input type="hidden" name="waktu_periksa" value="<?php echo $waktu_berobat; ?>" id="waktu_periksa">

						<span class="txt1 p-b-11">
							Pilih Penjamin
						</span>
						<div class="wrap-input100 validate-input m-b-12">
							<select class="form-control custom-select" id="penjamin" name="penjamin" <?php echo ($penjamin != "" || $kunjungan == "3") ? 'disabled' : ''; ?>>
								<option value="">Pilih Penjamin</option>
								<?php
								$data = mysqli_query($dbh, "SELECT kd_pj, png_jawab FROM penjab");
								while ($row=mysqli_fetch_array($data)) {?>
									<option value="<?php echo $row['kd_pj']; ?>" <?php echo ($row['kd_pj'] == $penjamin) ? 'selected' : ''; ?>><?php echo $row['png_jawab']; ?></option>
								<?php }
								?>
							</select>
							<?php if ($penjamin != "" || $kunjungan == "3"): ?>
								<input type="hidden" name="penjamin" value="<?php echo $penjamin; ?>">
							<?php endif; ?>
						</div>
						<?php echo $no_rujukan; ?>

						<div id="no_rujukan"  <?php echo ($rujukan != "") ? 'style=" width:100%;"' : 'style="display:none; width:100%;"'; ?>>
							<span class="txt1 p-b-11">
								Masukkan No Rujukan
							</span>
							<div class="wrap-input100 validate-input m-b-12">
								<input type="text" name="no_rujukan" value="" id="no_rujukan_1" class="form-control">
							</div>
						</div>

						<?php if ($kunjungan == "3"): ?>
							<span class="txt1 p-b-11">
								Masukkan No Surat Kontrol
							</span>
							<div class="wrap-input100 validate-input m-b-12">
								<input type="text" name="kontrol" value="" id="kontrol" class="form-control">
							</div>
						</div>
						<?php endif; ?>


						<div class="container-login100-form-btn">
							<!-- <button onclick="history.go(-1);"  class="login100-form-btn">Kembali </button> -->
							<a href="index.php" class="login100-form-btn"> Kembali</a>
							<button class="login100-form-btn"  style="margin-left: auto;" name="tampilkan">
								Daftar
							</button>
						</div>

					</form>
				</div>
			</div>
		</div>


		<!--===============================================================================================-->
		<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<script src="sweetalert/sweetalert2.all.min.js"></script>
		<script type="text/javascript">

		$( document ).ready(function() {
    if (<?php echo $kunjungan; ?> == 3 || <?php echo $kunjungan; ?> == "3") {
			var aktif ="";
			document.getElementById('no_rujukan').style.display = 'block';
			$.get("cek_aktif.php?no_kartu="+$("#kartu").val(),function(aktif){
			},"json");
			if (aktif == 0) {
				var list_rujuk = "";
				$.get("ajax-rujukan.php?no_kartu="+$("#kartu").val(),function(rujukan){
					var p_html = "<option value=''>Pilih No Rujukan</option>";
					for(var i=0;i<rujukan.length;i++){
						p_html += "<option value='"+rujukan[i].id+"'>"+rujukan[i].nama+"("+rujukan[i].id+")"+"</option>";
						// arr_rujukan[i] = {nama: rujukan[i].nama, id:rujukan[i].id};
						list_rujuk += '<input type="button" class="form-control" name="" value="'+rujukan[i].id+'" onclick="isi_rujukan(this);swal.close(); ">'+ rujukan[i].nama;
					}
					// console.log(list_rujuk);
					if (list_rujuk.includes("RUJUKAN TIDAK ADA")) {
						Swal.fire({
							title: 'Error!',
							text: 'RUJUKAN TIDAK DITEMUKAN',
							icon: 'error',
							confirmButtonText: 'Ok'
						});
					}else {
						$.get("cari_kontrol.php?no_kartu="+$("#kartu").val(),function(kontrol){
							if (kontrol) {
								$("#kontrol").val(kontrol.no_surat);
							}else {
								Swal.fire({
									title: 'Error!',
									text: 'NO SURAT KONTROL TIDAK DITEMUKAN',
									icon: 'error',
									confirmButtonText: 'Ok'
								});
							}
						},"json");
						Swal.fire({
							title: 'Pilih No Rujukan',
							html:
							list_rujuk
						});
					}

					// console.log("Hello world!");
					// $("#no_rujukan_1").html(p_html);
					// $("#no_rujukan_1").val(rujukan.id);
				},"json");
				// console.log(rujukan);
			}else {
				Swal.fire({
					title: 'Error!',
					text: 'No Kartu Tidak Terdaftar / Atau Tidak Aktif /n SILAHKAN MENGHUBUNGI PENDAFTARAN',
					icon: 'error',
					confirmButtonText: 'Ok'
				});
			}
    }
		});

		$(function(){
			$("#poli").change(function(){
				if($(this).val() != 0){
					$.get("proses-ajax.php?poli="+$(this).val()+"&hari="+$("#hari").val()+"&tanggal="+$("#tgl_kunjungan").val(),function(dokter){
						var p_html = "";
						// var waktu_periksa = "";
						for(var i=0;i<dokter.length;i++){
							p_html += "<option value='"+dokter[i].id+"'>"+dokter[i].nama+dokter[i]+"</option>";
							// waktu_periksa = dokter[0].waktu_periksa;
						}
						$("#dokter").html(p_html);
						// $("#waktu_periksa").val(waktu_periksa);
					},"json");
				}
			});
		});

		$

		$(function(){
			$("#dokter").change(function(){
				if($(this).val() != 0){
					var waktu = $("option:selected", this).text();
					if (waktu.includes("PAGI")) {
						$("#waktu_periksa").val(0);
					}else if (waktu.includes("SIANG")) {
						$("#waktu_periksa").val(1);
					}else if (waktu.includes("SORE")) {
						$("#waktu_periksa").val(2);
					}
				}
			});
		});

		$(function(){
			$("#penjamin").change(function(){
				if($(this).val() == 'BPJ'){
					var aktif ="";
					document.getElementById('no_rujukan').style.display = 'block';
					$.get("cek_aktif.php?no_kartu="+$("#kartu").val(),function(aktif){
					},"json");
					if (aktif == 0) {
						$.get("ajax-rujukan.php?no_kartu="+$("#kartu").val(),function(rujukan){
							var p_html = "<option value=''>Pilih No Rujukan</option>";
							var list_rujuk = "";
							for(var i=0;i<rujukan.length;i++){
								p_html += "<option value='"+rujukan[i].id+"'>"+rujukan[i].nama+"("+rujukan[i].id+")"+"</option>";
								// arr_rujukan[i] = {nama: rujukan[i].nama, id:rujukan[i].id};
								list_rujuk += '<input type="button" class="form-control" name="" value="'+rujukan[i].id+'" onclick="isi_rujukan(this);swal.close(); ">'+ rujukan[i].nama;
							}
							if (list_rujuk.includes("RUJUKAN TIDAK ADA")) {
								Swal.fire({
									title: 'Error!',
									text: 'RUJUKAN TIDAK DITEMUKAN',
									icon: 'error',
									confirmButtonText: 'Ok'
								});
								document.getElementById('no_rujukan').style.display = 'none';
								$("#no_rujukan_1").val('');
								$("#penjamin").val('');
							}else {
								Swal.fire({
									title: 'Pilih No Rujukan',
									html:
									list_rujuk
								});
							}
							// console.log("Hello world!");
							// $("#no_rujukan_1").html(p_html);
							// $("#no_rujukan_1").val(rujukan.id);
						},"json");
						// console.log(rujukan);

					}else {
						Swal.fire({
						  title: 'Error!',
						  text: 'No Kartu Tidak Terdaftar / Atau Tidak Aktif /n SILAHKAN MENGHUBUNGI PENDAFTARAN',
						  icon: 'error',
						  confirmButtonText: 'Ok'
						});
					}
				} else {
					document.getElementById('no_rujukan').style.display = 'none';
					$("#no_rujukan_1").val('');
				}
			});
		});

		function isi_rujukan(a) {
			var rujukan = $(a).val();
			$("#no_rujukan_1").val(rujukan);
			$.get("tgl_rujukan.php?no_rujukan="+$(a).val(),function(tgl_rujukan){
				var p_html = "";
				for(var i=0;i<tgl_rujukan.length;i++){
					p_html = tgl_rujukan[i].tgl;
				}
				console.log(p_html);
				$("#tgl_rujukan").val(p_html);
			},"json");
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
	<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
	<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
