<?php
// Database connection setup
$servername = "localhost";
$username = "root"; // your DB username
$password = ""; // your DB password
$dbname = "dolphin_crm";

// Create connection
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $plainPassword = $_POST['password'];
    $role = $_POST['role'];

    // Hash the password
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

    try {
        // Insert user into the database
        $sql = "INSERT INTO Users (firstname, lastname, password, email, role)
                VALUES (:firstname, :lastname, :password, :email, :role)";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':firstname', $firstName);
        $stmt->bindParam(':lastname', $lastName);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);

        // Execute the query
        $stmt->execute();

        // Redirect or display success message
        // header("Location: users.php");
        // exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

$conn = null;
?>