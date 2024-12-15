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
<<<<<<< Updated upstream
            /* Match .content background color */
=======
>>>>>>> Stashed changes
        }

        html {
            height: 100%;
<<<<<<< Updated upstream
            /* Ensure full height covers the viewport */
=======
>>>>>>> Stashed changes
        }

        .main-container {
            display: flex;
<<<<<<< Updated upstream
            /* Use flexbox for layout */
            min-height: 100vh;
            /* Make sure it stretches to fill the viewport height */
=======
            min-height: 100vh;
>>>>>>> Stashed changes
            width: 100%;
        }

        .top {
            position: sticky;
            top: 0;
            z-index: 1000;
<<<<<<< Updated upstream
            /* Ensure it stays above other elements */
            background-color: #fff;
            /* Add background to avoid transparency */
            height: 60px;
            /* Adjust to match your header's height */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            /* Optional shadow */
=======
            background-color: #fff;
            height: 60px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
>>>>>>> Stashed changes
        }

        .side {
            position: relative;
            background-color: #111;
            height: 100%;
            flex: 0 0 250px;
        }

        .content {
            margin-left: 250px;
<<<<<<< Updated upstream
            /* Offset to account for the side nav */
            padding-top: 80px;
            /* Adjust to clear the sticky header */
            background-color: #8f9092;
            /* Match body background color */
            min-width: 56rem;
            /*width: calc(100% - 250px); /* Fill remaining space */
            min-height: calc(100vh - 60px);
            /* Ensure it covers the viewport height minus header */
            box-sizing: border-box;
            /* Include padding in height calculation */
            display: inline-block;
            justify-content: center;
            /* Horizontally center the form-container */
            align-items: flex-start;
            /* Align the form-container to the top */
=======
            padding-top: 80px;
            background-color: #8f9092;
            min-width: 56rem;
            min-height: calc(100vh - 60px);
            box-sizing: border-box;
            display: inline-block;
            justify-content: center;
            align-items: flex-start;
>>>>>>> Stashed changes
        }

        .form-container {
            background-color: #fff;
<<<<<<< Updated upstream
            /* White background for form container */
            padding: 20px;
            /*width: 80%; /* Adjust width of the form container */
            max-width: 800px;
            /* Maximum width for the form */
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            /* Optional shadow */


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

=======
            padding: 20px;
            max-width: 800px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
                <form action="processNewContact.php" method="POST">


=======
                <form action="CreateContact.php" method="POST">
>>>>>>> Stashed changes
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
                            <input type="text" name="company" id="company" required><br>
                        </div>
                        <div>
                            <label for="type">Type:</label>
                            <select name="type" id="type" required>
                                <option value="sales lead">Sales Lead</option>
                                <option value="support">Support</option>
                            </select><br>

                        </div>
                    </div>

                    <div>
                        <label for="assigned_to">Assigned To:</label>
                        <select name="assigned_to" id="assigned_to" required>
                            <option value="">Select a User</option>
                            <?php
                            // Loop through users and create option elements for the dropdown
                            foreach ($users as $user) {
                                echo "<option value='" . $user['id'] . "'>" . $user['firstname'] . " " . $user['lastname'] . "</option>";
                            }
                            ?>
                        </select><br>
                    </div>

                    <div id="sbt-bt-container">
                        <button type="submit">Add Contact</button>

<<<<<<< Updated upstream
                    </div>
=======
                    <label for="company">Company:</label>
                    <input type="text" name="company" id="company" required><br>

                    <label for="type">Type:</label>
                    <select name="type" id="type" required>
                        <option value="sales lead">Sales Lead</option>
                        <option value="support">Support</option>
                    </select><br>

                    <label for="assigned_to">Assigned To:</label>
                    <select name="assigned_to" id="assigned_to" required>
                        <option value="">Select a User</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['id'] ?>"><?= $user['firstname'] . ' ' . $user['lastname'] ?></option>
                        <?php endforeach; ?>
                    </select><br>

                    <button type="submit">Add Contact</button>
>>>>>>> Stashed changes
                </form>
            </div>
        </div>
    </div>
</body>
<<<<<<< Updated upstream

=======
>>>>>>> Stashed changes
</html>