<?php
// Db.php - file ini untuk mengatur koneksi ke database

// Mulai session supaya bisa pakai session di script yang include ini (opsional, bisa dihapus kalau gak perlu)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Konfigurasi koneksi database
$host = "localhost";    // alamat server database
$user = "root";         // username database
$pass = "";             // password database
$dbname = "visionnotedb"; // nama database

// Buat koneksi MySQLi
$conn = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi, jika gagal hentikan program dan tampilkan error
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}



// set charset ke utf8 agar mendukung karakter internasional
$conn->set_charset("utf8");
?>
