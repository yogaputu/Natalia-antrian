<?php
$dbh = mysqli_connect("112.78.43.162", "root", "12500103Lynx", "simrs_natalia");

// Check if the connection to the database is established
if (!$dbh) {
    die("Database connection failed: " . mysqli_connect_error());
}

$poli       = $_GET['poli'];
$hari				= $_GET['hari'];
// $waktu			= $_GET['waktu'];
$tanggal		= $_GET['tanggal'];
// $query      = mysql_query("SELECT * FROM `province` WHERE country_id=".$country_id);
$sql        = mysqli_query($dbh, "SELECT dokter.nm_dokter, dokter.kd_dokter, jadwal.jam_mulai FROM dokter
JOIN jadwal ON dokter.kd_dokter = jadwal.kd_dokter
WHERE jadwal.kd_poli = '$poli' AND jadwal.hari_kerja = '$hari' 
");
// -- AND (jadwal.jam_mulai = '$waktu' OR jadwal.jam_selesai > '$waktu') 
// -- GROUP BY dokter.NAMA, dokter.ID, jadwal.WAKTU
// -- ORDER BY jadwal.WAKTU ASC
	$dokter  = array();
	while($data = mysqli_fetch_assoc($sql)){
		// if ($data->WAKTU == '0') {
		// 	$waktu_periksa = "(PAGI)";
		// }elseif ($data->WAKTU == '1') {
		// 	$waktu_periksa = "(SIANG)";
		// }else {
		// 	$waktu_periksa = "(SORE)";
		// }
		$dokter[] = array('id'=>$data['kd_dokter'],'nama'=>$data['nm_dokter']);
	}
	echo json_encode($dokter);
	?>
