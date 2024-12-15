<?php
require_once 'db_connection.php'; // Database connection file
session_start(); // Start the session

// Process the form data when the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $title = htmlspecialchars($_POST['title']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $telephone = htmlspecialchars($_POST['telephone']);
    $company = htmlspecialchars($_POST['company']);
    $type = htmlspecialchars($_POST['type']);
    $assigned_to = intval($_POST['assigned_to']);
    $created_by = intval($_SESSION['user_id']); // Get the session user ID

    // Validate mandatory fields
    if (!$firstname || !$lastname || !$email || !$type) {
        $error_message = "Firstname, Lastname, Email, and Type are required.";
    } elseif (!in_array($type, ['sales lead', 'support'])) {
        $error_message = "Invalid contact type.";
    } else {
        // SQL to insert data into Contacts table
        $query = "INSERT INTO Contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by, created_at) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

        // Prepare the query
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            $error_message = "Error preparing query: " . $conn->error;
        } else {
            // Bind parameters
            $stmt->bind_param(
                'sssssssii',
                $title,
                $firstname,
                $lastname,
                $email,
                $telephone,
                $company,
                $type,
                $assigned_to,
                $created_by
            );

            // Execute query
            if ($stmt->execute()) {
                $success_message = "New contact successfully added!";
            } else {
                $error_message = "Error adding contact: " . $stmt->error;
            }
            $stmt->close();
        }
    }

    $conn->close();
}
?>
