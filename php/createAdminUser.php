<?php
// Database connection setup
$servername = "localhost";
$username = "root"; // your DB username
$password = ""; // your DB password
$dbname = "your_database_name";

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

    // Insert user into the database
    $sql = "INSERT INTO users (email, password, first_name, last_name, created_at, updated_at)
            VALUES (:email, :password, :first_name, :last_name, NOW(), NOW())";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':first_name', $firstName);
    $stmt->bindParam(':last_name', $lastName);

    // Execute the query
    if ($stmt->execute()) {
        echo "Admin user added successfully.";
    } else {
        echo "Error: " . $stmt->errorInfo();
    }
} else {
    echo "Admin user already exists.";
}
?>
