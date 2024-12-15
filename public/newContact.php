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
    <title>New Contact - Dolphin CRM</title>
    <link rel="stylesheet" href="css/styles-index.css" />

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #8f9092;
        }

        html {
            height: 100%;
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
            margin-left: 250px;
            padding-top: 80px;
            background-color: #8f9092;
            min-width: 56rem;
            min-height: calc(100vh - 60px);
            box-sizing: border-box;
            display: inline-block;
            justify-content: center;
            align-items: flex-start;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            max-width: 800px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        #grid-container {
            display: grid;
            grid-template-columns: auto auto;
            grid-template-rows: auto auto auto auto auto auto;
            column-gap: 3em;
        }

        #title {
            width: auto;
        }

        #assigned_to {
            width: auto;
        }

        #sbt-bt-container {
            display: flex;
            justify-content: flex-end;
        }

        form label {
            display: block;
            margin-bottom: 8px;
        }

        form input,
        form select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        button {
            background-color: #0056b3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }



        button:hover {
            background-color: #004494;
        }
    </style>

</head>

<body>
    <!-- Top Navbar -->
    <div class="top">
        <?php include '../php/HTML-base/navbar.php'; ?>
    </div>

    <div class="main-container">
        <!-- Sidebar -->
        <div class="side">
            <?php include '../php/HTML-base/side-nav.php'; ?>
        </div>

        <!-- Main Content -->
        <div class="content">
            <h1>New Contact</h1>

            <div class="form-container">
                <form action="../php/API/CreateContact.php" method="POST">
                    <label for="title">Title:</label>
                    <select name="title" id="title" required>
                        <option value="Mr">Mr</option>
                        <option value="Ms">Ms</option>
                        <option value="Mrs">Mrs</option>
                    </select><br>

                    <div id="grid-container">
                        <div>
                            <label for="firstname">First Name:</label>
                            <input type="text" name="firstname" id="firstname" required><br>
                        </div>

                        <div>
                            <label for="lastname">Last Name:</label>
                            <input type="text" name="lastname" id="lastname" required><br>
                        </div>

                        <div>
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" required><br>
                        </div>
                        <div>
                            <label for="telephone">Telephone:</label>
                            <input type="text" name="telephone" id="telephone"><br>
                        </div>
                        <div>
                            <label for="company">Company:</label>
                            <input type="text" name="company" id="company"><br>
                        </div>
                        <div>
                            <label for="type">Type:</label>
                            <select name="type" id="type" required>
                                <option value="sales lead">Sales Lead</option>
                                <option value="support">Support</option>
                            </select><br>
                        </div>

                    </div>

                    <label for="assigned_to">Assigned To:</label>
                    <select name="assigned_to" id="assigned_to" required>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['id'] ?>"><?= $user['firstname'] . ' ' . $user['lastname'] ?></option>
                        <?php endforeach; ?>
                    </select><br>

                    <div id="sbt-bt-container">
                        <button type="submit">Add Contact</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>