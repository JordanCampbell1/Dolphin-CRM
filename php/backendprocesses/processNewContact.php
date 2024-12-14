<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Error: User not logged in.";
    exit();
}

// Get the logged-in user's ID
$created_by = $_SESSION['user_id'];

// Database connection variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dolphin_crm";

try {
    // Create PDO connection to the database
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the INSERT query
    $sql = "INSERT INTO Contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by, created_at, updated_at) 
            VALUES (:title, :firstname, :lastname, :email, :telephone, :company, :type, :assigned_to, :created_by, NOW(), NOW())";

    $stmt = $conn->prepare($sql);

    // Bind form data to query
    $stmt->bindParam(':title', $_POST['title']);
    $stmt->bindParam(':firstname', $_POST['firstname']);
    $stmt->bindParam(':lastname', $_POST['lastname']);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':telephone', $_POST['telephone']);
    $stmt->bindParam(':company', $_POST['company']);
    $stmt->bindParam(':type', $_POST['type']);
    $stmt->bindParam(':assigned_to', $_POST['assigned_to']);
    $stmt->bindParam(':created_by', $created_by);

    // Execute the query
    $stmt->execute();

    echo "Contact added successfully!";
    header("Location: dashboard.php"); // Redirect to the dashboard or any other page
    exit();

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}

// Close the database connection
$conn = null;
?>
