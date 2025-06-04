<?php
session_start();
include "Db.php"; // Pastikan ini mengarah ke file koneksi database yang benar

// Misalnya kamu pakai session login:
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    http_response_code(401);
    echo json_encode(['error' => 'Belum login']);
    exit;
}

$conn = new mysqli("localhost", "root", "", "visionnotedb");

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Koneksi gagal: " . $conn->connect_error]);
    exit;
}

$stmt = $conn->prepare("SELECT id, title, pos_x, pos_y FROM notes WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$notes = [];
while ($row = $result->fetch_assoc()) {
    $notes[] = $row;
}

echo json_encode($notes);

$stmt->close();
$conn->close();
?>
