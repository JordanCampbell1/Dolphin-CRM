<?php
require_once '../php/config.php';
session_start();

// Debugging: Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start output buffering
ob_start();

if (!isset($_SESSION['user_id'])) {
    die("Access denied. Please log in.");
}

$error_message = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debugging: Output POST data
    var_dump($_POST);

    $title = htmlspecialchars(trim($_POST['title']));
    $firstname = htmlspecialchars(trim($_POST['firstname']));
    $lastname = htmlspecialchars(trim($_POST['lastname']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $telephone = htmlspecialchars(trim($_POST['telephone']));
    $company = htmlspecialchars(trim($_POST['company']));
    $type = htmlspecialchars(trim($_POST['type']));
    $assigned_to = intval($_POST['assigned_to']);
    $created_by = intval($_SESSION['user_id']);

    if (empty($firstname) || empty($lastname) || !$email || empty($type)) {
        $error_message = "Required fields are missing.";
    } elseif (!in_array($type, ['sales lead', 'support'])) {
        $error_message = "Invalid type.";
    } else {
        try {
            $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "INSERT INTO Contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by, created_at) 
                      VALUES (:title, :firstname, :lastname, :email, :telephone, :company, :type, :assigned_to, :created_by, NOW())";
            $stmt = $conn->prepare($query);

            $stmt->execute([
                ':title' => $title,
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':email' => $email,
                ':telephone' => $telephone,
                ':company' => $company,
                ':type' => $type,
                ':assigned_to' => $assigned_to,
                ':created_by' => $created_by,
            ]);

            // Debugging: Check execution result
            if ($stmt->rowCount() > 0) {
                $success_message = "New contact added!";
            } else {
                $error_message = "Insert failed. No rows affected.";
            }
        } catch (PDOException $e) {
            $error_message = "Error: " . $e->getMessage();
        }
    }
}

// Debugging: Output messages
if (!empty($error_message)) {
    $_SESSION['error'] = $error_message;
    echo $error_message; // Debugging
    ob_end_clean(); // Clear buffer
    header("Location: ../../public/newContact.php");
    exit();
}

if (!empty($success_message)) {
    $_SESSION['success'] = $success_message;
    echo $success_message; // Debugging
    ob_end_clean(); // Clear buffer
    header("Location: ../../public/dashboard.php");
    exit();
}
?>
