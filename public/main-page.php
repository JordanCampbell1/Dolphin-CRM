<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../php/HTML-base/head.php';    ?>
    <link rel="stylesheet" href="css/styles-index.css" />
    <script src="/public/js/navigation.js"></script>
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


        <div id="main-content-container">

        </div>


    </div>
</body>

</html>