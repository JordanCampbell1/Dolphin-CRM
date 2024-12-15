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

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../php/HTML-base/head.php'; ?>
    <title>Add New User - Dolphin CRM</title>
    <link rel="stylesheet" href="css/styles-index.css" />
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #fff;
        }

        .main-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        .top {
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: #fff;
            height: 60px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .side {
            position: relative;
            background-color: #111;
            height: 100%;
            flex: 0 0 250px;
        }

        .content {
            padding: 20px;
            flex-grow: 1;
            min-height: calc(100vh - 60px);
            box-sizing: border-box;
            margin-top: 0;
            background-color: #8f9092;
        }

        .content-header {
            margin-bottom: 20px;
            margin-left: 120px;
            width: 88%;
        }

        .content-header h1 {
            margin: 0;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            margin-left: 120px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 80%;
        }

        .form-container form {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-container form .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-container form label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-container form input,
        .form-container form select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }

        .form-container .form-actions {
            grid-column: 2 / 3;
            display: flex;
            justify-content: flex-end;
        }

        .form-container .form-actions button {
            padding: 10px 20px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-container .form-actions button:hover {
            background-color: #004494;
        }
    </style>
</head>
<body>
    <div class="top">
        <?php include '../php/HTML-base/navbar.php'; ?>
    </div>

    <div class="main-container">
        <div class="side">
            <?php include '../php/HTML-base/side-nav.php'; ?>
        </div>

        <div class="content">
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
        </div>
    </div>
</body>
</html>