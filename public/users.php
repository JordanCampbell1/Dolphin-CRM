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
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #fff; /* Set the overall background color to white */
        }

        .main-container {
            display: flex; /* Use flexbox for layout */
            min-height: 100vh; /* Ensure it stretches to fill the viewport height */
            width: 100%;
        }

        .top {
            position: sticky;
            top: 0;
            z-index: 1000; /* Ensure it stays above other elements */
            background-color: #fff; /* White background for the header */
            height: 60px; /* Adjust to match your header's height */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Optional shadow */
        }

        .side {
            position: relative;
            background-color: #111;
            height: 100%;
            flex: 0 0 250px;
        }

        .content {
            padding: 20px;
            flex-grow: 1; /* Take remaining space */
            min-height: calc(100vh - 60px); /* Full height minus the header height */
            box-sizing: border-box; /* Include padding in height calculation */
            margin-top: 0; /* Ensure no space above the content */
            background-color: #8f9092; /* Slight grey color */
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            width: 88%;
        }

        .content-header h1 {
            margin-top: 0; /* Removes the gap under the header */
            margin-bottom: 20px; /* Adds space below the h1 */
            margin-left:120px;
            width: 80%;
        }

        .table-container {
            background-color: #fff; /* White background for table */
            padding: 20px;
            margin-left:120px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 80%;
        }

        .users-table {
            width: 100%;
            border-collapse: collapse;
        }

        .users-table th, .users-table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .users-table th {
            background-color: #f2f2f2;
            color: #333;
        }

        .users-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .users-table tr:hover {
            background-color: #f1f1f1;
        }

        .add-user-btn {
            padding: 10px 20px;
            background-color: #0056b3;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .add-user-btn:hover {
            background-color: #004494;
        }


    </style>
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
                <a href="addUser.php" class="add-user-btn">Add User</a>
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
