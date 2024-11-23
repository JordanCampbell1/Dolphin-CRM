<?php
// Include the setup file for insert file
include '../php/index.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../php/HTML-base/head.php'; ?>
</head>

<body>
    <?php include '../php/HTML-base/navbar.php'; ?>

    <!-- Login Section -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Login</h3>

                    <!-- Login Form -->
                    <form method="POST">
                        <!-- Email input -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                        </div>

                        <!-- Password input -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="btn submit-btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</body>

</html>