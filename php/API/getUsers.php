<?php
$servername = "localhost";
$username = "root";  // Your DB username
$password = "";      // Your DB password
$dbname = "dolphin_crm";  // Your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to select all users
$sql = "SELECT id, firstname, lastname, email, role, created_at FROM Users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. " - Email: " . $row["email"]. " - Role: " . $row["role"]. " - Created At: " . $row["created_at"]. "<br>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>