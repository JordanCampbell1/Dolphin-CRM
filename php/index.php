<?php
session_start();

// Check if it's the user's first visit
if (!isset($_SESSION['admin_created'])) {
    // Include or require the PHP script that adds the admin user
    include('createAdminUser.php');
    
    // Set a session flag so it doesn't run again
    $_SESSION['admin_created'] = true;
}

session_destroy();
?>