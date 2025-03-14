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

  use LZCompressor\LZString as LZString;

  require('LZCompressor/LZString.php');
  require('LZCompressor/LZContext.php');
  require('LZCompressor/LZData.php');
  require('LZCompressor/LZReverseDictionary.php');
  require('LZCompressor/LZUtil.php');
  require('LZCompressor/LZUtil16.php');
  include 'koneksi.php';
  // include 'query.php';
  // $data = "9667";
  // $secretKey = "5aR549A8D1";
  $tanggal = date('Y-m-d', strtotime( $_GET["tgl"]));
  $date = date('Y-m-d H:i:s', strtotime( $_GET["tgl"]));
  $hari = $_GET["hari"];
  // $waktu = $_GET["waktu"];
  $norm = $_GET["norm"];


  $data = "19733";
  $secretKey = "2jS0A514ED";
  $userkey = "64341530008e74c5275eab800f8b87b4";

  // Computes the timestamp
  date_default_timezone_set('UTC');
  $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
  // Computes the signature by hashing the salt with the secret key as the key
  $signature = hash_hmac('sha256', $data."&".$tStamp, $secretKey, true);
  $key = $data.$secretKey.$tStamp;
  // base64 encode…
  $encodedSignature = base64_encode($signature);

  // urlencode…
  // $encodedSignature = urlencode($encodedSignature);

  // echo "X-cons-id: " .$data ." ";
  // echo "X-timestamp:" .$tStamp ." ";
  // echo "X-signature: " .$encodedSignature;
  // echo "<br>";
  $headers=array(
    "X-cons-id: ".$data,
    "X-timestamp: ".$tStamp,
    "X-signature: ".$encodedSignature,
    "user_key: ".$userkey,
    "Content-type: application/json"
  );
  $CEK = ibase_query($dbh, "SELECT * FROM MH_PASIEN WHERE NORM LIKE '%$norm%'");
    $ps1 = ibase_fetch_object($CEK);
    $nokartu = $ps1->NO_JAMINAN;



  $method = "GET";
  $base_URL = "https://apijkn-dev.bpjs-kesehatan.go.id/vclaim-rest-dev/";
  // $base_URL = "https://new-api.bpjs-kesehatan.go.id:8080/new-vclaim-rest/";


  $ch=curl_init();
  curl_setopt($ch,CURLOPT_URL, $base_URL."Rujukan/Peserta/'$nokartu'");
  curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
  // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  // curl_setopt($ch, CURLOPT_POSTFIELDS, $NoPeserta);
  curl_setopt($ch,CURLOPT_TIMEOUT,3);
  curl_setopt($ch,CURLOPT_HTTPGET,1);
  curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);

  $content=curl_exec($ch);
  curl_close($ch);



  $data=json_decode($content, true);
  // print_r($data);




  // $tgl_tujukan = $data['response']['rujukan']['tglKunjungan'];
  // $date_rujukan = date('Y-m-d', strtotime($tgl_tujukan));
  // $akhir_rujukan = date('Y-m-d', strtotime($date_rujukan."+86 days"));


  function stringDecrypt($key, $string){


              $encrypt_method = 'AES-256-CBC';

              // hash
              $key_hash = hex2bin(hash('sha256', $key));

              // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
              $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);

              $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

              return $output;
          }

          // function lzstring decompress
          // download libraries lzstring : https://github.com/nullpunkt/lz-string-php
          function decompress($string){

              return LZCompressor\LZString::decompressFromEncodedURIComponent($string);

          }

          $adecode = stringDecrypt($key, $data['response']);
          // echo decompress($a);
          $datajs=json_decode(decompress($adecode), true);
          // print_r($data1);
          // echo $data['poli']['0']['nama'];
           // $adecode = stringDecrypt($key, $data['response']);
          // // echo decompress($a);
          // $data1=json_decode(decompress($a), true);
          // print_r($data1);
          // echo $data['poli']['0']['nama'];
    $kartu = $datajs['rujukan']['peserta']['noKartu'];
    $norujukan = $datajs['rujukan']['noKunjungan'];
		// $tgl_lahir = date("Y-m-d", strtotime($_GET["tgl_lahir"]));


		$sql_norm = ibase_query($dbh, "SELECT * FROM MH_PASIEN WHERE NO_JAMINAN = '$kartu'");
		if ($ps = ibase_fetch_object($sql_norm)) {
			$nokartu = $ps->NO_JAMINAN;
      $nocm = $ps->NORM;
			$nama = $ps->NAMA;
			$alamat = $ps->ALAMAT;
		}else {
			echo "<script>alert('No Kartu BPJS Masih Kosong, SILAHKAN MENGHUBUNGI PENDAFTARAN');window.location = 'index.php';</script>";
		}


		$sql = ibase_query($dbh,"SELECT MH_TEMPATLAYANAN.TEMPAT_LAYANAN, MH_TEMPATLAYANAN.ID FROM MH_TEMPATLAYANAN
			JOIN TH_JADWAL ON TH_JADWAL.ID_TMPLAYANAN = MH_TEMPATLAYANAN.ID
			WHERE MH_TEMPATLAYANAN.TEMPAT_LAYANAN LIKE '%POLI%' AND TH_JADWAL.HARI = '$hari'  AND TH_JADWAL.AKTIF = 'TRUE'
			GROUP BY MH_TEMPATLAYANAN.TEMPAT_LAYANAN, MH_TEMPATLAYANAN.ID ");

    $rujukan = ibase_query($dbh,"SELECT * FROM MH_PASIEN WHERE NORM = '$norm'");
    $trujukan = ibase_fetch_object($rujukan);

		?>
		<div class="limiter">
			<div class="container-login100">
				<div class="wrap-login100 p-l-85 p-r-85 p-t-55 p-b-55">
					<form class="login100-form validate-form flex-sb flex-w" action="validasi.php" method="get">
						<span class="login100-form-title p-b-32">
							Pilih Poli Tujuan
						</span>
							<span class="focus-input100"></span>
						<input type="hidden" name="hari" id="hari" value="<?php echo $hari;?>">
						<input type="hidden" name="tanggal" id="tanggal" value="<?php echo $date;?>">
						<input type="hidden" name="tgl_kunjungan" id="tgl_kunjungan" value="<?php echo $tanggal;?>">
						<input type="hidden" name="waktu" id="waktu" value="<?php echo $waktu;?>">
						<input type="hidden" name="norm" value="<?php echo $nocm; ?>">
            <div class="txt1 p-b-11">
                test>>>>>> <?php echo $norujukan; ?> oke
            </div>
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
						<div class="wrap-input100 validate-input m-b-12">
							<select class="form-control custom-select" name="poli" id="poli">
								<option value="">Pilih Poli Tujuan</option>
								<?php while ($row = ibase_fetch_object($sql)) {?>
									<option value="<?php echo $row->ID;?>"><?php echo $row->TEMPAT_LAYANAN; ?></option>
									<?php
								}
								?>
							</select>
						</div>

						<span class="txt1 p-b-11">
							Pilih Dokter
						</span>
						<div class="wrap-input100 validate-input m-b-12" data-validate = "Password is required">
							<select class="form-control custom-select" name="dokter" id="dokter">
							</select>
						</div>

						<span class="txt1 p-b-11">
							Pilih Penjamin
						</span>
						<div class="wrap-input100 validate-input m-b-12">
							<select class="form-control custom-select" id="penjamin" name="penjamin">
								<option value="">Pilih Penjamin</option>
								<?php
								$data = ibase_query("SELECT ID, NAMA_PENJAMIN FROM RH_PENJAMIN WHERE RH_PENJAMIN.IS_AKTIF IS TRUE");
								while ($row=ibase_fetch_object($data)) {?>
									<option value="<?php echo $row->ID; ?>"><?php echo $row->NAMA_PENJAMIN; ?></option>
								<?php }
								?>
							</select>
						</div>

						<!-- <div id="no_rujukan" style="display:none">
							<span class="txt1 p-b-11">
								Masukkan No Rujukan
							</span>
							<div class="wrap-input100 validate-input m-b-12">
								<input type="text" name="no_rujukan" value="" class="form-control">
							</div>
						</div> -->

						<div class="container-login100-form-btn">
							<button class="login100-form-btn">
								Daftar
							</button>
						</div>

					</form>
				</div>
			</div>
		</div>


		<!--===============================================================================================-->
		<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<script type="text/javascript">
		$(function(){
			$("#poli").change(function(){
				if($(this).val() != 0){
					$.get("proses-ajax.php?poli="+$(this).val()+"&hari="+$("#hari").val()+"&waktu="+$("#waktu").val()+"&tanggal="+$("#tgl_kunjungan").val(),function(dokter){
						var p_html = "";
						for(var i=0;i<dokter.length;i++){
							p_html += "<option value='"+dokter[i].id+"'>"+dokter[i].nama+"</option>";
						}
						$("#dokter").html(p_html);
					},"json");
				}
			});
		});

		$(function(){
			$("#penjamin").change(function(){
				if($(this).val() == 6){
					document.getElementById('no_rujukan').style.display = 'block';
				} else {
					document.getElementById('no_rujukan').style.display = 'none';
				}
			});
		});
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
