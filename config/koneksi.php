<?php
$host = 'localhost';
$username = 'root';
$password = 'devia238'; // atau sesuai setting kamu
$database = 'sikpu';

$koneksi = new mysqli($host, $username, $password, $database);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

$koneksi->set_charset("utf8");
?>