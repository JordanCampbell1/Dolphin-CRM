<?php
// Start the session
session_start();


// Database connection variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dolphin_crm";

// Fetch users from the database
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch all users
    $sql = "SELECT id, firstname, lastname, email, role, created_at FROM Users";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../php/HTML-base/head.php'; ?>
    <title>Users - Dolphin CRM</title>
    <link rel="stylesheet" href="css/styles-index.css" />
    <link rel="stylesheet" href="css/users.css">
</head>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../php/HTML-base/head.php'; ?>
    <title>Users - Dolphin CRM</title>
    <link rel="stylesheet" href="css/styles-index.css" />
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
                <h1>Users</h1>
                <a href="newuser.php" class="add-user-btn">Add User</a>
            </div>

            <div class="table-container">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($users) > 0) {
                            foreach ($users as $user) {
                                echo "<tr>";
                                echo "<td>{$user['firstname']} {$user['lastname']}</td>";
                                echo "<td>{$user['email']}</td>";
                                echo "<td>{$user['role']}</td>";
                                echo "<td>{$user['created_at']}</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No users found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>

</html>
