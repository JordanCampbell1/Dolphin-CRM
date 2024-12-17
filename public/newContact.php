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

<title>New Contact - Dolphin CRM</title>
<link rel="stylesheet" href="css/newContact.css">
<script src="js/createContact.js"></script>

<h1>New Contact</h1>

<div class="form-container">
    <form id="new-contact-form" method="POST">
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