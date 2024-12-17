<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$host = "localhost";
$dbname = "dolphin_crm";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die(json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]));
}

$contactId = $_GET['contact_id'] ?? null;

if (!$contactId) {
    echo json_encode(['error' => 'Contact ID is required.']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT id, comment, created_at FROM notes WHERE contact_id = :contact_id ORDER BY created_at DESC");
    $stmt->execute(['contact_id' => $contactId]);
    $notes = $stmt->fetchAll();

    echo json_encode(['success' => true, 'notes' => $notes]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Failed to fetch notes: ' . $e->getMessage()]);
}
?>
