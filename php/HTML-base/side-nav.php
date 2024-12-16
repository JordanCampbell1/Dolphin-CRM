<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/styles-index.css">
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
        <a href="#" onclick="loadContent('dashboard.php')"><img src="../public/images/home.png" alt="home icon">Home</a>
        <a href="#" onclick="loadContent('newContact.php')"><img src="../public/images/user.png" alt="new contact icon">New Contact</a>
        <a href="#" onclick="loadContent('users.php')"><img src="../public/images/friends.png" alt="users icon">Users</a>
        <a href="index.php" id="logout-link"><img src="../public/images/logout.png" alt="logout icon">Logout</a>
    </div>
</body>
</html>