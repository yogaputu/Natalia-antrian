<?php
include 'koneksi.php';
$norm = $_GET['norm'];

// Establish database connection
$dbh = mysqli_connect("112.78.43.162", "root", "12500103Lynx", "simrs_natalia");

// Check if the connection to the database is established
if (!$dbh) {
    die("Database connection failed: " . mysqli_connect_error());
}

$query = mysqli_query($dbh, "SELECT * FROM pasien WHERE no_rkm_medis LIKE '%$norm%'");

// Check if the query execution was successful
if (!$query) {
    die("Query execution failed: " . mysqli_error($dbh));
}

$pasien = mysqli_fetch_assoc($query);

if ($pasien) {
    $data = array(
        'nama'      =>  $pasien['nm_pasien'],
        'tgl_lahir' =>  $pasien['tgl_lahir'],
        'alamat'    =>  $pasien['alamat']
    );
     json_encode($data);
} else {
     json_encode(null); // Return null if no data found
}

// Close the database connection
mysqli_close($dbh);
  ?>
