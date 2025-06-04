<?php
// note_api.php - API endpoint for CRUD operations
require_once 'Db.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Prevent PHP errors from corrupting JSON output
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

try {
    $method = $_SERVER['REQUEST_METHOD'];
    $input = json_decode(file_get_contents('php://input'), true);

    // Get note_id from URL or default to 1 for now
    $note_id = isset($_GET['note_id']) ? intval($_GET['note_id']) : 1;

    switch ($method) {
        case 'GET':
            // READ - Get all elements for a note
            $sql = "SELECT * FROM note_elements WHERE note_id = ? AND isDeleted = 0 ORDER BY created_at";
            $stmt = $conn->prepare($sql);
            
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            
            $stmt->bind_param("i", $note_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $elements = [];
            while ($row = $result->fetch_assoc()) {
                // Convert JSON fields back to arrays/objects
                if ($row['list']) $row['list'] = json_decode($row['list'], true);
                if ($row['tasks']) $row['tasks'] = json_decode($row['tasks'], true);
                if ($row['start']) $row['start'] = json_decode($row['start'], true);
                if ($row['end']) $row['end'] = json_decode($row['end'], true);
                
                $elements[] = $row;
            }
            
            echo json_encode(['success' => true, 'elements' => $elements]);
            break;

        case 'POST':
            // CREATE - Add new element
            $sql = "INSERT INTO note_elements (note_id, type, x, y, z, width, height, text, url, list, tasks, start, end) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql);
            
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            
            // Prepare data
            $type = $input['type'] ?? '';
            $x = $input['x'] ?? 0;
            $y = $input['y'] ?? 0;
            $z = $input['z'] ?? 3;
            $width = $input['width'] ?? null;
            $height = $input['height'] ?? null;
            $text = $input['text'] ?? null;
            $url = $input['url'] ?? null;
            $list = isset($input['list']) ? json_encode($input['list']) : null;
            $tasks = isset($input['tasks']) ? json_encode($input['tasks']) : null;
            $start = isset($input['start']) ? json_encode($input['start']) : null;
            $end = isset($input['end']) ? json_encode($input['end']) : null;
            
            $stmt->bind_param("isiiiissssssss", $note_id, $type, $x, $y, $z, $width, $height, $text, $url, $list, $tasks, $start, $end);
            
            if ($stmt->execute()) {
                $new_id = $conn->insert_id;
                echo json_encode(['success' => true, 'id' => $new_id]);
            } else {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            break;

        case 'PUT':
            // UPDATE - Update existing element
            $id = $input['id'] ?? 0;
            
            if ($id <= 0) {
                throw new Exception("Invalid ID provided");
            }
            
            $sql = "UPDATE note_elements SET 
                    type = ?, x = ?, y = ?, z = ?, width = ?, height = ?, 
                    text = ?, url = ?, list = ?, tasks = ?, start = ?, end = ?,
                    updated_at = CURRENT_TIMESTAMP
                    WHERE id = ?";
            
            $stmt = $conn->prepare($sql);
            
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            
            // Prepare data
            $type = $input['type'] ?? '';
            $x = $input['x'] ?? 0;
            $y = $input['y'] ?? 0;
            $z = $input['z'] ?? 3;
            $width = $input['width'] ?? null;
            $height = $input['height'] ?? null;
            $text = $input['text'] ?? null;
            $url = $input['url'] ?? null;
            $list = isset($input['list']) ? json_encode($input['list']) : null;
            $tasks = isset($input['tasks']) ? json_encode($input['tasks']) : null;
            $start = isset($input['start']) ? json_encode($input['start']) : null;
            $end = isset($input['end']) ? json_encode($input['end']) : null;
            
            $stmt->bind_param(
                "isiiisissssss",
                $note_id,
                $type,
                $x,
                $y,
                $z,
                $width,
                $height,
                $text,
                $url,
                $list,
                $tasks,
                $start,
                $end
            );

            
            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            break;

        case 'DELETE':
            // DELETE - Soft delete element
            $id = $input['id'] ?? 0;
            
            if ($id <= 0) {
                throw new Exception("Invalid ID provided");
            }
            
            $sql = "UPDATE note_elements SET isDeleted = 1, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
            $stmt = $conn->prepare($sql);
            
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }
            
            $stmt->bind_param("i", $id);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            break;

        default:
            echo json_encode(['success' => false, 'error' => 'Method not allowed']);
            break;
    }

} catch (Exception $e) {
    // Log the error and return JSON error response
    error_log("API Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} catch (Error $e) {
    // Handle fatal errors
    error_log("Fatal Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'Internal server error']);
}

if (isset($conn)) {
    $conn->close();
}
?>