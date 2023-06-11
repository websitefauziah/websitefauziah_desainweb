<?php include("inc_header.php")?>
<?php
$host = "localhost"; // Ganti dengan host Anda
$username = "username"; // Ganti dengan username Anda
$password = "password"; // Ganti dengan password Anda
$database = "nama_database"; // Ganti dengan nama database Anda

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
