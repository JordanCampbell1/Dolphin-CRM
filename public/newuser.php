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
        header("Location: users.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

$conn = null;
?>


<title>Add New User - Dolphin CRM</title>
<link rel="stylesheet" href="css/newuser.css">



<div class="content-header">
    <h1>Add New User</h1>
</div>

<div class="form-container">
    <form action="" method="POST">
        <div class="form-group">
            <label for="first-name">First Name</label>
            <input type="text" id="first-name" name="first_name" required>
        </div>
        <div class="form-group">
            <label for="last-name">Last Name</label>
            <input type="text" id="last-name" name="last_name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select id="role" name="role" required>
                <option value="Member">Member</option>
                <option value="Admin">Admin</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit">Save</button>
        </div>
    </form>
</div>