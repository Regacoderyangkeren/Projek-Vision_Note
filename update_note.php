<?php
session_start();
require_once "Db.php"; // koneksi database

// Ambil data JSON
$data = json_decode(file_get_contents('php://input'), true);

// Pastikan semua data diperlukan ada
if (!isset($data['id'], $data['title'], $data['pos_x'], $data['pos_y'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Data tidak lengkap']);
    exit;
}

$note_id = $data['id'];
$title = $data['title'];
$pos_x = $data['pos_x'];
$pos_y = $data['pos_y'];

// Update query
$query = "UPDATE notes SET title = ?, pos_x = ?, pos_y = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("siii", $title, $pos_x, $pos_y, $note_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal update note']);
}
?>
