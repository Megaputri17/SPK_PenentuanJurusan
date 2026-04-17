<?php

$host     = "localhost";
$user     = "root";      
$password = "";          
$database = "spk_jurusan";

// Membuat koneksi
$conn = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Optional: set charset biar aman (hindari bug karakter)
mysqli_set_charset($conn, "utf8");

?>
