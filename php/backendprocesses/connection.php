<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database credentials
$servername = "localhost";
$dbname = "dolphin_crm";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fetch_users'])) {
        $sql = "SELECT id, firstname, lastname, email, role, created_at FROM Users";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h3>Fetched Users:</h3>";
        echo "<pre>";
        print_r($users);
        echo "</pre>";
    }
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
