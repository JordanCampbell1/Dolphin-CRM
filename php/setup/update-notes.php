<?php
session_start(); // Start the session to access session variables

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Database credentials
$host = "localhost";
$dbname = "dolphin_crm";
$username = "root";
$password = "";

// Check if user is logged in and user_id is set in session
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

// Use the user_id from the session
$user_id = $_SESSION['user_id'];

try {
    // Establish database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    // Respond with an error if the connection fails
    die(json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve POST parameters
    $contactId = $_POST['contact_id'] ?? null;
    $comment = $_POST['comment'] ?? null;
    $created_by = $user_id;

    // Validate input data
    if (!$contactId || !$comment || !$created_by) {
        echo json_encode(['error' => 'Contact ID, comment, and user ID are required.']);
        exit;
    }

    try {
        // Prepare and execute SQL statement to insert note
        $stmt = $pdo->prepare("INSERT INTO notes (contact_id, comment, created_by, created_at) VALUES (:contact_id, :comment, :created_by, NOW())");
        $stmt->bindParam(':contact_id', $contactId, PDO::PARAM_INT);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':created_by', $created_by, PDO::PARAM_INT); // Changed from :user_id to :created_by
        $stmt->execute();

        // Respond with success message
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        // Respond with an error if the insert fails
        echo json_encode(['error' => 'Failed to add note: ' . $e->getMessage()]);
    }
} else {
    // Respond with an error if the request method is invalid
    echo json_encode(['error' => 'Invalid request method.']);
}
?>