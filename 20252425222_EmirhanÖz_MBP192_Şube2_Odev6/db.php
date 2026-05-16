<?php

$host = "localhost";
$kullanici = "root";
$sifre = "";
$veritabani = "okul_db";

$conn = new mysqli($host, $kullanici, $sifre, $veritabani);

if ($conn->connect_error) {
    die("Veritabanı bağlantı hatası: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

?>