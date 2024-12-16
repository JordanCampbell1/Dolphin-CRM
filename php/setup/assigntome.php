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

    // Check if contact ID is provided via POST
    if (!isset($_POST['id'])) {
        throw new Exception("No contact ID provided");
    }

    $contactId = $_POST['id'];
    $userId = $_SESSION['user_id'];

    // Prepare and execute update
    $stmt = $pdo->prepare("UPDATE Contacts SET assigned_to = :user_id, updated_at = NOW() WHERE id = :contact_id");
    $result = $stmt->execute([
        'user_id' => $userId,
        'contact_id' => $contactId
    ]);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Contact assigned successfully']);
        exit;
    } else {
        throw new Exception("Failed to assign contact");
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