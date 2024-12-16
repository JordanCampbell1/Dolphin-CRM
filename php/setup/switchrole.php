<?php
session_start();
require_once '../config.php';

try {
    // Database connection
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        throw new Exception("User not logged in");
    }

    // Check if contact ID and type are provided via POST
    if (!isset($_POST['id']) || !isset($_POST['type'])) {
        throw new Exception("No contact ID or type provided");
    }

    $contactId = $_POST['id'];
    $newType = $_POST['type'];

    // Prepare and execute update
    $stmt = $pdo->prepare("UPDATE Contacts SET type = :new_type, updated_at = NOW() WHERE id = :contact_id");
    $result = $stmt->execute([
        'new_type' => $newType,
        'contact_id' => $contactId
    ]);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Contact type switched successfully']);
        exit;
    } else {
        throw new Exception("Failed to switch contact type");
    }
} catch (Exception $e) {
    // Log the error
    error_log(date('[Y-m-d H:i:s] ') . $e->getMessage() . PHP_EOL, 3, 'error.log');
    
    // Send error response
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit;
}
?>