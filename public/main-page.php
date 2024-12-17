<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../php/HTML-base/head.php';    ?>
    <link rel="stylesheet" href="css/styles-index.css" />
    <script src="js/navigation.js"></script>
</head>

<body>
    <div class="top">
        <?php
        $headerClass = 'secondary-header';
        $headerId = 'header2';
        include '../php/HTML-base/navbar.php';
        ?>
    </div>

    <div class="main-container">

        <div class="side">
            <?php include '../php/HTML-base/side-nav.php'; ?>
        </div>

        <div class="content">
            <div class="container">

                <div id="main-content-container">
                    <?php include 'dashboard.php' ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>