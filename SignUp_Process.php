<?php
// Mulai sesi supaya bisa simpan pesan error atau sukses antar halaman
session_start();
require_once "Db.php";

// Pastikan form dikirim dengan method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data input dari form, trim untuk hilangkan spasi di awal/akhir
    $username = trim($_POST['Username']);
    $email = trim($_POST['Email']);
    $password = $_POST['Password'];
    $confirmPassword = $_POST['ConfirmPassword'];

    // Cek apakah ada input yang kosong
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $_SESSION['error'] = "Semua kolom harus diisi!";  // simpan pesan error di session
        header("Location: SignUp_Page.php");  // redirect ke halaman SignUp_Page
        exit();  // hentikan eksekusi script
    }

    // Validasi format email menggunakan filter bawaan PHP
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Format email tidak valid!";
        header("Location: SignUp_Page.php");
        exit();
    }

    // Cek apakah password dan konfirmasi password sama
    if ($password !== $confirmPassword) {
        $_SESSION['error'] = "Password dan konfirmasi password tidak cocok!";
        header("Location: SignUp_Page.php");
        exit();
    }

    // Cek apakah username atau email sudah ada di database
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email); // bind parameter untuk query agar aman dari SQL injection
    $stmt->execute();
    $stmt->store_result(); // simpan hasil query agar bisa cek jumlah baris

    if ($stmt->num_rows > 0) {
        // Kalau ada, artinya username atau email sudah dipakai
        $_SESSION['error'] = "Username atau email sudah digunakan!";
        $stmt->close(); // tutup statement
        header("Location: SignUp_Page.php");
        exit();
    }
    $stmt->close(); // tutup statement jika username/email belum ada

    // Hash password agar tersimpan dengan aman di database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Siapkan query insert user baru
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        // Jika insert berhasil, simpan pesan sukses
        $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
        $stmt->close();
        $delay_seconds = 2; // waktu tunggu sebelum redirect
        header("Refresh: {$delay_seconds} url=Login_Page.php"); // redirect ke halaman login
        exit();
    } else {
        // Jika gagal simpan data ke database
        $_SESSION['error'] = "Terjadi kesalahan saat menyimpan data.";
        $stmt->close();
        header("Location: SignUp_Page.php");
        exit();
    }
} else {
    // Kalau akses bukan via POST, langsung redirect ke halaman SignUp_Page
    header("Location: SignUp_Page.php");
    exit();
}
?>
