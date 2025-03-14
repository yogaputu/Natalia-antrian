<?php

$dbh = mysqli_connect("112.78.43.162", "root", "12500103Lynx", "simrs_natalia");

// Check if the connection to the database is established
if (!$dbh) {
    die("Database connection failed: " . mysqli_connect_error());
}
date_default_timezone_set('Asia/Jakarta');
$today = date("Y-m-d");
	$date = date('Y/m/d', strtotime( $_GET["tanggal"]));
	$jam = date('H:i:s');
	$dokter = $_GET["dokter"];
	// $hari = $_GET["hari"];
	$penjamin = $_GET["penjamin"];
	$norm = $_GET["norm"];
	$poli = $_GET["poli"];
	$waktu = $_GET["waktu_periksa"];
	$tgl_antrian = date("Y-m-d H:i:s", strtotime("$date $jam"));
	$no_rujukan = $_GET["no_rujukan"];
	$kartu = $_GET["kartu"];
	$tgl_rujukan = date('Y-m-d', strtotime($_GET["tgl_rujukan"]));
	$kunjungan = $_GET["kunjungan"];
	$reservasi = $_GET["reservasi"];
	$kontrol = $_GET["kontrol"];

	$tanggal=$_GET["tanggal"];
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

	$data =mysqli_query($dbh, "SELECT MAX(reg_periksa.no_reg) AS no_antrian FROM reg_periksa
	WHERE tgl_registrasi = '$date' AND reg_periksa.kd_dokter = '$dokter'
	GROUP BY reg_periksa.kd_dokter");
	
	$quota = mysqli_query($dbh, "SELECT kuota FROM jadwal WHERE kd_dokter = '$dokter' AND hari_kerja ='$hari'");
	$quota_new = mysqli_fetch_assoc($quota);
	$quota_new['kuota'];

//booking periksa = th antrian
//booking registrasi = th reservasi

if ($kunjungan == 1) {
	$cek_data = mysqli_query($dbh, "SELECT A.no_rkm_medis FROM booking_periksa A
		WHERE tanggal = '$date' AND A.no_rkm_medis = '$norm' AND A.kd_dokter = '$dokter' AND A.kd_poli = '$poli'");
}else {
	$cek_data =mysqli_query($dbh, "SELECT waktu_kunjungan FROM booking_registrasi
		WHERE kd_booking ='$reservasi'");
}
		$id1 = mysqli_query($dbh, "SELECT MAX(kd_booking) AS max_id FROM booking_registrasi");
		$id1 = mysqli_fetch_assoc($id1);

		$id_reservasi = $id1['max_id'];
		$id_reservasi_baru = (int) $id_reservasi;

		$id_reservasi_baru++;

		// $data1 =mysqli_query($dbh, "SELECT MH_PROVIDER.ID_ANTRIAN FROM MH_PROVIDER WHERE MH_PROVIDER.ID = '$dokter'");


		if ($row = mysqli_fetch_assoc($data)) {
			$antrian = $row['no_antrian'];
		}else {
			$antrian = 0;
		}
			$antrian++;

		// $kode = ibase_fetch_object($data1);

		// $awalan = $kode->ID_ANTRIAN;
		// if ($kunjungan == 1) {
		// 	// code...
		// 	$urutan = (int) $antrian;
		// }else {
		// 	$urutan = 0;
		// }

		// $urutan++;

		$no_antrian = $antrian;

		$data2 = mysqli_query($dbh, "SELECT jam_mulai FROM jadwal WHERE kd_poli = '$poli' AND hari_kerja = '$hari'");
		$dilayani = mysqli_fetch_assoc($data2);
		// $est_dilayani = date("Y-m-d H:i:s", strtotime("$date $dilayani[jam_mulai]"));

		$no_rawat_akhir = mysqli_fetch_array(mysqli_query($dbh, "SELECT max(no_rawat) FROM reg_periksa WHERE tgl_registrasi='$date'"));
        $no_urut_rawat = substr($no_rawat_akhir[0], 11, 6);
        $no_rawat = $date.'/'.sprintf('%06s', ($no_urut_rawat + 1));

		$status_pasien = mysqli_fetch_array(mysqli_query($dbh,"SELECT count(no_rkm_medis) as rkm_medis FROM reg_periksa GROUP BY no_rkm_medis"));
		if ($status_pasien != 2) {
			$statuspasien = "Baru";
		}else{
			$statuspasien = "Lama";
		}
		$statuspasien;

		$get_pasien = mysqli_fetch_array(mysqli_query($dbh, "SELECT timestampdiff(year, tgl_lahir, curdate()) as umur FROM pasien WHERE no_rkm_medis = '$norm'"));
        $umurdaftar = $get_pasien['umur'];

		if ($antrian < $quota_new['kuota']) {
			if ($penjamin == "BPJ") {
				if (mysqli_fetch_assoc($cek_data)) {
					echo $daftar = "ANDA SUDAH MEMPUNYAI KUNJUNGAN DI HARI YANG SAMA";
					// echo "<script>alert('ANDA SUDAH MEMPUNYAI KUNJUNGAN DI HARI YANG SAMA / SUDAH CHECK IN');window.location = 'index.php';</script>";
				}else {
					if ($kunjungan == 1) {
						$kunjung = mysqli_query($dbh, "INSERT INTO reg_periksa (`no_reg`, `no_rawat`, `tgl_registrasi`, `jam_reg`, `kd_dokter`, `no_rkm_medis`, `kd_poli`, `p_jawab`, `almt_pj`, `hubunganpj`, `biaya_reg`, `stts`, `stts_daftar`, `status_lanjut`, `kd_pj`, `umurdaftar`, `sttsumur`, `status_bayar`)
VALUES ('$no_antrian', '$no_rawat', '$date', '$jam', '$dokter', '$norm', '$poli', '-', '-', '-', '10000', 'Belum', '$statuspasien', 'Ralan', '$penjamin', '$umurdaftar', 'Th', 'Belum Bayar')");

if ($kunjung) {
    // Insertion successful
    echo "Data inserted successfully.";
} else {
    // Insertion failed
    echo "Error: " . mysqli_error($dbh);
}


						// $kunjungdetil = mysqli_query($dbh, "INSERT INTO TH_KUNJUNGANDETIL (KD_KUNJUNGAN,ID_TMPLAYANAN,ID_PROVIDER,KD_LAYANAN,JUMLAH,TARIF,PETUGAS) VALUES ('$a->KODE','$poli','1','1800000001','1','10000','0')");
						// $antrian = mysqli_query($dbh, "INSERT INTO TH_ANTRIAN (ID_ANTRIAN, NORM, ID_TMPLAYANAN, ID_PROVIDER, ID_PENJAMIN, NO_RUJUKAN, EST_DILAYANI, WAKTU) VALUES ('$awalan', '$norm', '$poli', '$dokter', '$penjamin', '$no_rujukan', '$date', '$waktu')");
					}elseif ($kunjungan == 2) {
						$checkin = mysqli_query($dbh, "UPDATE booking_registrasi SET waktu_kunjungan = CURRENT_TIMESTAMP WHERE kd_booking ='$reservasi'");
						$kunjung = mysqli_query($dbh, "INSERT INTO reg_periksa (`no_reg`, `no_rawat`, `tgl_registrasi`, `jam_reg`, `kd_dokter`, `no_rkm_medis`, `kd_poli`, `p_jawab`, `almt_pj`, `hubunganpj`, `biaya_reg`, `stts`, `stts_daftar`, `status_lanjut`, `kd_pj`, `umurdaftar`, `sttsumur`, `status_bayar`)
VALUES ('$no_antrian', '$no_rawat', '$date', '$jam', '$dokter', '$norm', '$poli', '-', '-', '-', '10000', 'Belum', '$statuspasien', 'Ralan', '$penjamin', '$umurdaftar', 'Th', 'Belum Bayar')");

if ($kunjung) {
    // Insertion successful
    echo "Data inserted successfully.";
} else {
    // Insertion failed
    echo "Error: " . mysqli_error($dbh);
}
						// $kunjungdetil = mysqli_query($dbh, "INSERT INTO TH_KUNJUNGANDETIL (KD_KUNJUNGAN,ID_TMPLAYANAN,ID_PROVIDER,KD_LAYANAN,JUMLAH,TARIF,PETUGAS) VALUES ('$a->KODE','$poli','1','1800000001','1','10000','0')");
					}else {
						$kunjung = mysqli_query($dbh, "INSERT INTO reg_periksa (`no_reg`, `no_rawat`, `tgl_registrasi`, `jam_reg`, `kd_dokter`, `no_rkm_medis`, `kd_poli`, `p_jawab`, `almt_pj`, `hubunganpj`, `biaya_reg`, `stts`, `stts_daftar`, `status_lanjut`, `kd_pj`, `umurdaftar`, `sttsumur`, `status_bayar`)
VALUES ('$no_antrian', '$no_rawat', '$date', '$jam', '$dokter', '$norm', '$poli', '-', '-', '-', '10000', 'Belum', '$statuspasien', 'Ralan', '$penjamin', '$umurdaftar', 'Th', 'Belum Bayar')");

if ($kunjung) {
    // Insertion successful
    echo "Data inserted successfully.";
} else {
    // Insertion failed
    echo "Error: " . mysqli_error($dbh);
}
						// $kunjungdetil = mysqli_query($dbh, "INSERT INTO TH_KUNJUNGANDETIL (KD_KUNJUNGAN,ID_TMPLAYANAN,ID_PROVIDER,KD_LAYANAN,JUMLAH,TARIF,PETUGAS) VALUES ('$a->KODE','$poli','1','1800000001','1','10000','0')");
						// $antrian = mysqli_query($dbh, "INSERT INTO TH_ANTRIAN (ID_ANTRIAN, NORM, ID_TMPLAYANAN, ID_PROVIDER, ID_PENJAMIN, NO_RUJUKAN, EST_DILAYANI, WAKTU) VALUES ('$awalan', '$norm', '$poli', '$dokter', '$penjamin', '$no_rujukan', '$date', '$waktu')");
					}
				}
			} else {
				if (mysqli_fetch_assoc($cek_data)) {
					$daftar = "ANDA SUDAH MEMPUNYAI KUNJUNGAN DI HARI YANG SAMA";
					// echo "<script>alert('ANDA SUDAH MEMPUNYAI KUNJUNGAN DI HARI YANG SAMA / SUDAH CHECK IN');window.location = 'index.php';</script>";
				}else {
					if ($kunjungan == 1) {
						$kunjung = mysqli_query($dbh, "INSERT INTO reg_periksa (`no_reg`, `no_rawat`, `tgl_registrasi`, `jam_reg`, `kd_dokter`, `no_rkm_medis`, `kd_poli`, `p_jawab`, `almt_pj`, `hubunganpj`, `biaya_reg`, `stts`, `stts_daftar`, `status_lanjut`, `kd_pj`, `umurdaftar`, `sttsumur`, `status_bayar`)
VALUES ('$no_antrian', '$no_rawat', '$date', '$jam', '$dokter', '$norm', '$poli', '-', '-', '-', '10000', 'Belum', '$statuspasien', 'Ralan', '$penjamin', '$umurdaftar', 'Th', 'Belum Bayar')");

if ($kunjung) {
    // Insertion successful
    echo "Data inserted successfully.";
} else {
    // Insertion failed
    echo "Error: " . mysqli_error($dbh);
}
						// $kunjungdetil = mysqli_query($dbh, "INSERT INTO TH_KUNJUNGANDETIL (KD_KUNJUNGAN,ID_TMPLAYANAN,ID_PROVIDER,KD_LAYANAN,JUMLAH,TARIF,PETUGAS) VALUES ('$a->KODE','$poli','1','1800000001','1','10000','0')");
						// $antrian = mysqli_query($dbh, "INSERT INTO TH_ANTRIAN (ID_ANTRIAN, NORM, ID_TMPLAYANAN, ID_PROVIDER, ID_PENJAMIN, EST_DILAYANI, WAKTU) VALUES ('$awalan', '$norm', '$poli', '$dokter', '$penjamin', '$date', '$waktu')");
					}elseif($kunjungan == 2) {
						$checkin = mysqli_query($dbh, "UPDATE booking_registrasi SET waktu_kunjungan = CURRENT_TIMESTAMP WHERE kd_booking ='$reservasi'");
						$kunjung = mysqli_query($dbh, "INSERT INTO reg_periksa (`no_reg`, `no_rawat`, `tgl_registrasi`, `jam_reg`, `kd_dokter`, `no_rkm_medis`, `kd_poli`, `p_jawab`, `almt_pj`, `hubunganpj`, `biaya_reg`, `stts`, `stts_daftar`, `status_lanjut`, `kd_pj`, `umurdaftar`, `sttsumur`, `status_bayar`)
VALUES ('$no_antrian', '$no_rawat', '$date', '$jam', '$dokter', '$norm', '$poli', '-', '-', '-', '10000', 'Belum', '$statuspasien', 'Ralan', '$penjamin', '$umurdaftar', 'Th', 'Belum Bayar')");

if ($kunjung) {
    // Insertion successful
    echo "Data inserted successfully.";
} else {
    // Insertion failed
    echo "Error: " . mysqli_error($dbh);
}
						// $kunjungdetil = mysqli_query($dbh, "INSERT INTO TH_KUNJUNGANDETIL (KD_KUNJUNGAN,ID_TMPLAYANAN,ID_PROVIDER,KD_LAYANAN,JUMLAH,TARIF,PETUGAS) VALUES ('$a->KODE','$poli','1','1800000001','1','10000','0')");
					}else {
						$kunjung = mysqli_query($dbh, "INSERT INTO reg_periksa (`no_reg`, `no_rawat`, `tgl_registrasi`, `jam_reg`, `kd_dokter`, `no_rkm_medis`, `kd_poli`, `p_jawab`, `almt_pj`, `hubunganpj`, `biaya_reg`, `stts`, `stts_daftar`, `status_lanjut`, `kd_pj`, `umurdaftar`, `sttsumur`, `status_bayar`)
VALUES ('$no_antrian', '$no_rawat', '$date', '$jam', '$dokter', '$norm', '$poli', '-', '-', '-', '10000', 'Belum', '$statuspasien', 'Ralan', '$penjamin', '$umurdaftar', 'Th', 'Belum Bayar')");

if ($kunjung) {
    // Insertion successful
    echo "Data inserted successfully.";
} else {
    // Insertion failed
    echo "Error: " . mysqli_error($dbh);
}
						// $kunjungdetil = mysqli_query($dbh, "INSERT INTO TH_KUNJUNGANDETIL (KD_KUNJUNGAN,ID_TMPLAYANAN,ID_PROVIDER,KD_LAYANAN,JUMLAH,TARIF,PETUGAS,SURAT_KONTROL) VALUES ('$a->KODE','$poli','1','1800000001','1','10000','0','$kontrol')");
						// $antrian = mysqli_query($dbh, "INSERT INTO TH_ANTRIAN (ID_ANTRIAN, NORM, ID_TMPLAYANAN, ID_PROVIDER, ID_PENJAMIN, EST_DILAYANI, WAKTU) VALUES ('$awalan', '$norm', '$poli', '$dokter', '$penjamin', '$date', '$waktu')");
					}
				}
			}
			//Kondisi apakah berhasil atau tidak
			if ($checkin OR $antrian) {
				echo "<script>window.location = 'landing.php?norm=". $norm. "&no_rawat=". $no_rawat."&kontrol=".$kontrol."';</script>";
				// echo "landing.php";
				echo $a['no_rawat'];
				echo $no_antrian;
				echo '<br>';
echo $no_rawat;
echo '<br>';
echo $date;
echo '<br>';
echo $jam;
echo '<br>';
echo $dokter;
echo '<br>';
echo $norm;
echo '<br>';
echo $poli;
echo '<br>';
echo $statuspasien;
echo '<br>';
echo $penjamin;
echo '<br>';
echo $umurdaftar;
echo '<br>';
				exit;

			}else {
				// echo "<script>alert('Data gagal diproses');</script>";
				echo "Data gagal diproses";
				exit;
			}

		}else {
			// echo "<script>alert('QUOTA SUDAH PENUH');window.location = 'index.php';</script>";
			echo "QUOTA SUDAH PENUH";
			exit;
		}
	?>
