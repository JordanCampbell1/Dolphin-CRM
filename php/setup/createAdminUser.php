<?php
// Database connection setup
$servername = "localhost";
$username = "root"; // your DB username
$password = ""; // your DB password
$dbname = "dolphin_crm";

// Create connection
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check if the admin user already exists
$email = 'admin@project2.com';
$stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$userExists = $stmt->fetchColumn();

if ($userExists == 0) {
    // If the user does not exist, create it
    $plainPassword = 'password123'; // Unhashed password
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
    $firstName = 'Admin';
    $lastName = 'User';
    $role = 'ADMIN';

    // Insert user into the database
    $sql = "INSERT INTO users (firstname, lastname, password, email, role)
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
    // if ($stmt->execute()) {
    //     echo "Admin user added successfully.";
    // } else {
    //     echo "Error: " . $stmt->errorInfo();
    // }
} else {
    // echo "Admin user already exists.";
}

$conn = null;

?>
