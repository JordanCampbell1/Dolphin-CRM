<?php
// Include database connection
require_once 'db_connection.php'; // Ensure this file connects to the `dolphin_crm` database

// Check if request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $title = htmlspecialchars($_POST['title']);
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $telephone = htmlspecialchars($_POST['telephone']);
    $company = htmlspecialchars($_POST['company']);
    $type = htmlspecialchars($_POST['type']);
    $assigned_to = intval($_POST['assigned_to']);
    $created_by = intval($_POST['created_by']); // Retrieve this from the session

    // Validate mandatory fields
    if (!$firstname || !$lastname || !$email || !$type) {
        http_response_code(400);
        echo json_encode(["error" => "Firstname, Lastname, Email, and Type are required."]);
        exit;
    }

    // Check if type is valid
    if (!in_array($type, ['sales lead', 'support'])) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid contact type."]);
        exit;
    }

    // Insert into database
    $query = "INSERT INTO Contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by, created_at) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        http_response_code(500);
        echo json_encode(["error" => "Failed to prepare query."]);
        exit;
    }

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

    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode(["success" => "Contact created successfully."]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to create contact: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
