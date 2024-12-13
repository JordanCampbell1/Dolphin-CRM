<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../../php/HTML-base/head.php'; ?>
    <title>New Contact - Dolphin CRM</title>
    <link rel="stylesheet" href="../css/styles-index.css" />

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #8f9092; /* Match .content background color */
        }

        html {
            height: 100%; /* Ensure full height covers the viewport */
        }

        .main-container {
            display: flex; /* Use flexbox for layout */
            min-height: 100vh; /* Make sure it stretches to fill the viewport height */
            width: 100%;
        }

        .top {
            position: sticky;
            top: 0;
            z-index: 1000; /* Ensure it stays above other elements */
            background-color: #fff; /* Add background to avoid transparency */
            height: 60px; /* Adjust to match your header's height */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Optional shadow */
        }

        .side {
            position: relative;
            background-color: #111;
            height: 100%;
            flex: 0 0 250px;
        }

        .content {
            margin-left: 250px; /* Offset to account for the side nav */
            padding-top: 80px; /* Adjust to clear the sticky header */
            background-color: #8f9092; /* Match body background color */
            min-width: 56rem;
            /*width: calc(100% - 250px); /* Fill remaining space */
            min-height: calc(100vh - 60px); /* Ensure it covers the viewport height minus header */
            box-sizing: border-box; /* Include padding in height calculation */
            display: inline-block;
            justify-content: center; /* Horizontally center the form-container */
            align-items: flex-start; /* Align the form-container to the top */
        }

        .form-container {
            background-color: #fff; /* White background for form container */
            padding: 20px;
            /*width: 80%; /* Adjust width of the form container */
            max-width: 800px; /* Maximum width for the form */
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Optional shadow */
        }


        form label {
            display: block;
            margin-bottom: 8px;
        }

        form input, form select {
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
    <div class="top">
        <?php include '../../php/HTML-base/navbar.php'; ?>
    </div>

    <div class="main-container">
        <div class="side">
            <?php include '../../php/HTML-base/side-nav.php'; ?>
        </div>

        <div class="content">
            <h1>New Contact</h1>

            <div class="form-container">
                <form action="processNewContact.php" method="POST">
                    <label for="title">Title:</label>
                    <select name="title" id="title" required>
                        <option value="Mr">Mr</option>
                        <option value="Ms">Ms</option>
                        <option value="Mrs">Mrs</option>
                    </select><br>

                    <label for="firstname">First Name:</label>
                    <input type="text" name="firstname" id="firstname" required><br>

                    <label for="lastname">Last Name:</label>
                    <input type="text" name="lastname" id="lastname" required><br>

                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required><br>

                    <label for="telephone">Telephone:</label>
                    <input type="text" name="telephone" id="telephone"><br>

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
                        <?php
                        // Loop through users and create option elements for the dropdown
                        foreach ($users as $user) {
                            echo "<option value='" . $user['id'] . "'>" . $user['firstname'] . " " . $user['lastname'] . "</option>";
                        }
                        ?>
                    </select><br>

                    <button type="submit">Add Contact</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
