<?php 
$host      = "localhost";
$user      = "id20897170_fauziah";
$pass      = "dWLo@$vyQV3dky2D*VIk";
$db        = "id20897170_db";

$koneksi   = mysqli_connect($host,$user,$pass,$db);
if(!$koneksi){
    die("Gagal terkoneksi");
}