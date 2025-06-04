<?php
// delete_note.php

// Mengambil data dari request
$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(["error" => "ID tidak ditemukan"]);
    exit;
}

$conn = new mysqli("localhost", "root", "", "visionnotedb"); // sesuaikan kredensialnya

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Koneksi gagal: " . $conn->connect_error]);
    exit;
}

$stmt = $conn->prepare("DELETE FROM notes WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Gagal menghapus note"]);
}

$stmt->close();
$conn->close();
?>
