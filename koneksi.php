<?php
// $host='G:\dbrs\123\DB_HIS_NATALIA.FDB';
// $username='SYSDBA';
// $password='masterkey';
// $dbh=ibase_connect($host,$username,$password);


$servername = "112.78.43.162";
$database = "simrs_natalia";
$username = "root";
$password = "12500103Lynx";

// untuk tulisan bercetak tebal silakan sesuaikan dengan detail database Anda
// membuat koneksi
// Establish database connection
$dbh = mysqli_connect("112.78.43.162", "root", "12500103Lynx", "simrs_natalia");

// Check if the connection to the database is established
if (!$dbh) {
    die("Database connection failed: " . mysqli_connect_error());
}
else{
    // echo "Koneksi berhasil";
}
mysqli_close($dbh);

?>
