<?php
// Cek apakah form dikirim dengan method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Validasi sederhana
    if (empty($name) || empty($email) || empty($message)) {
        die("Harap isi semua kolom.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email tidak valid.");
    }

    // Setup email tujuan dan subjek
    $to = "visionnoteproject@gmail.com";  // Ganti dengan email penerima yang kamu mau
    $subject = "Pesan dari Contact Us - Vision Note";

    // Format isi email
    $body = "Nama: $name\n";
    $body .= "Email: $email\n\n";
    $body .= "Pesan:\n$message\n";

    // Header email supaya dari alamat email user
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Kirim email
    if (mail($to, $subject, $body, $headers)) {
        // Jika berhasil
        echo "Pesan berhasil dikirim. Terima kasih sudah menghubungi kami!";
    } else {
        // Jika gagal
        echo "Maaf, pesan gagal dikirim. Silakan coba lagi nanti.";
    }
} else {
    // Jika akses langsung tanpa POST
    echo "Akses tidak diperbolehkan.";
}
