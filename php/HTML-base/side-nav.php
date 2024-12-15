<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/styles-index.css">
    <title>Side Navigation</title>
    <style>
        /* Basic styles for the side navigation */
        .sidenav img{
            width: 16px;
            margin-right: 16px;
        }
        .sidenav{
            padding: 20px; /* Optional padding for spacing */
        }
        
    </style>
</head>
<body>
    <div class="sidenav">
        <a href="dashboard.php"><img src="../public/images/home.png" alt="home ico">Home</a>
        <a href="newContact.php"><img src="../public/images/user.png" alt="new contact icon">New Contact</a>
        <a href="users.php"><img src="../public/images/friends.png" alt="users icon">Users</a>
        <a href="index.php" id="logout-link"><img src="../public/images/logout.png" alt="logout icon">Logout</a>
    </div>
</body>
</html>