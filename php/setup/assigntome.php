<?php
session_start();

//$_SESSION['id'] = '1';       

$host = 'localhost';
$username = 'user123';
$password = 'password123';
$dbname = 'dolphin_crm';

try {
    // Database connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the contact ID from the POST data
    $contactId = $_POST['id'];

    // Get the ID of the logged-in user
    $userId = $_SESSION['id'];

    // Update the assigned_to field in the contacts table
    $stmt = $conn->prepare("UPDATE contacts SET assigned_to = :id, updated_at = NOW() WHERE id = :contact_id");
    $stmt->execute([
        'id' => $userId,
        'contact_id' => $contactId
    ]);

    echo "Contact assigned successfully!";
} catch (PDOException $e) {
    // Handle connection or query error
    echo "Error: " . $e->getMessage();
}
?>
