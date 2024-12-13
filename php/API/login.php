<?php
// Set Content-Type header to application/json for JSON response
header('Content-Type: application/json');

// Database connection variables
$servername = "localhost";
$username = "root";  // Your DB username
$password = "";      // Your DB password
$dbname = "dolphin_crm";  // Your DB name

// echo "test stuff";

try {
    // Create PDO connection to the database
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Read the raw POST data (JSON)
    $data = json_decode(file_get_contents("php://input"));

    // Check if email and password are present in the request body
    if (!isset($data->email) || !isset($data->password)) {
        echo json_encode(["success" => false, "message" => "Email and password are required."]);
        exit();
    }

    // Sanitize email and password
    $email = filter_var($data->email, FILTER_SANITIZE_EMAIL);
    $password = trim(htmlspecialchars($data->password));

    // SQL query to find user by email
    $sql = "SELECT * FROM Users WHERE email = :email LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    // Check if a user with the given email exists
    if ($stmt->rowCount() > 0) {
        // Fetch the user data from the database
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the provided password against the stored hashed password
        if (password_verify($password, $user['password'])) {
             // Start a session and store user information
             session_start();
             $_SESSION['user_id'] = $user['id'];
             $_SESSION['user_name'] = $user['firstname'] . ' ' . $user['lastname'];
             
            // Successful login: return success response with user data (exclude password)
            unset($user['password']);  // Remove password from the response
            echo json_encode(["success" => true, "message" => "Login successful", "user" => $user]);
        } else {
            // Invalid password
            echo json_encode(["success" => false, "message" => "Invalid email or password"]);
        }
    } else {
        // User not found with that email
        echo json_encode(["success" => false, "message" => "User not found"]);
    }

} catch (PDOException $e) {
    // Handle any errors with the database connection or query
    echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
}

// Close the database connection
$conn = null;
?>
