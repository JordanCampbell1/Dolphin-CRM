<?php
session_start();  

// Set the user ID in the session (for testing purposes)
//$_SESSION['user_id'] = '1'; // Ensure this is stored during login

$host = 'localhost';
$username = 'user123';
$password = 'password123';
$dbname = 'dolphin_crm';

try {
    // Database connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the contact ID and new role from the POST data
    $contactId = $_POST['id'];
    $newRole = $_POST['type'];

    // Update the role and updated_at fields in the contacts table
    $stmt = $conn->prepare("UPDATE contacts SET type = :new_role, updated_at = NOW() WHERE id = :contact_id");
    $stmt->execute([
        'new_role' => $newRole,
        'contact_id' => $contactId
    ]);

    // Log a debug message on successful query execution
    $debugMessage = "Query executed successfully. Contact ID: $contactId updated to role: $newRole";
    file_put_contents('debug.log', date('Y-m-d H:i:s') . ' ' . $debugMessage . PHP_EOL, FILE_APPEND);

} catch (PDOException $e) {
    // Log the error message
    $errorMessage = "Error: " . $e->getMessage();
    file_put_contents('error.log', date('Y-m-d H:i:s') . ' ' . $errorMessage . PHP_EOL, FILE_APPEND);
}
?>
