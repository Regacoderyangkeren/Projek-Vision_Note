<?php
session_start();
require_once "Db.php";

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Hitung berapa note user ini sudah punya
// Hitung jumlah note milik user ini
$countQuery = "SELECT COUNT(*) as total FROM notes WHERE user_id = ?";
$stmtCount = $conn->prepare($countQuery);
$stmtCount->bind_param("i", $user_id);
$stmtCount->execute();
$result = $stmtCount->get_result();
$rowCount = $result->fetch_assoc();
$count = $rowCount['total'];

// Rumus posisi grid
$margin = 30;
$startTop = 100;
$boxWidth = 280;
$boxHeight = 280;
$notesPerRow = 4;

$row = floor($count / $notesPerRow);
$col = $count % $notesPerRow;

$pos_x = $margin + ($col * ($boxWidth + $margin));
$pos_y = $startTop + ($row * ($boxHeight + $margin));

$title = "New Note";

$query = "INSERT INTO notes (user_id, title, pos_x, pos_y) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("isii", $user_id, $title, $pos_x, $pos_y);

if ($stmt->execute()) {
    $new_id = $stmt->insert_id;
    echo json_encode([
        'id' => $new_id,
        'user_id' => $user_id,
        'title' => $title,
        'pos_x' => $pos_x,
        'pos_y' => $pos_y,
    ]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to create note']);
}
?>
