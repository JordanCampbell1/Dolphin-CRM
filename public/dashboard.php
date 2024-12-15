<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../php/HTML-base/head.php';
        try {
        // Replace with your actual database credentials
            $host = "localhost";
            $dbname = "dolphin_crm";
            $username = "root"; // Or your database username
            $password = ""; // Or your database password

            // Create a new PDO object
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

            // Set PDO error mode to exception for better debugging
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Query to fetch all users
            $sql = "SELECT id, firstname, lastname, email, role, created_at FROM Users";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        }    catch (PDOException $e) {
        // Handle connection errors
        die("Database connection failed: " . $e->getMessage());

        }catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
            exit();
        }


    ?>
    <title>Dashboard - Dolphin CRM</title>
    <script src="js/navigation.js"></script>
    <link rel="stylesheet" href="css/styles-index.css" />
    <link rel="stylesheet" href="css/dashboard.css">
    
</head>
<body>
<script src='js/dashboard.js'></script>
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
                <!-- Header with h1 and button inline -->
                <div class="header">
                    <h1>Dashboard</h1>
                    <button class="btn" onclick="window.location.href='newContact.php'">Add New Contact</button>
                </div>
                <div id="content_container">
                    <!-- Filter Container -->
                    <div id="filter-container">
                        <span id="filtertxt"><img src="../public/images/filter.png" alt="home ico"> Filter By:</span>
                        <span class="filter-option" data-filter="all">All</span>
                        <span class="filter-option" data-filter="sales leads">Sales Leads</span>
                        <span class="filter-option" data-filter="support">Support</span>
                        <span class="filter-option" data-filter="assigned">Assigned to me</span>
                    </div>

                    <!-- Table wrapped in a white background container -->
                    <div class="table-container">
                        <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Company</th>
                                <th>Type of Contact</th>
                            </tr>
                            <tbody id="contacts-table-body">
                                <?php
                                try {
                                    $stmt = $conn->query("SELECT id, title, CONCAT(firstname, ' ', lastname) AS full_name, email, company, type, assigned_to FROM Contacts");
                                    $stmt->execute();
                                    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($contacts as $contact) {
                                        $typeClass = strtolower(str_replace(' ', '-', $contact['type']));
                                        echo "<tr data-type='{$contact['type']}' data-assigned='{$contact['assigned_to']}'>
                                                <td>{$contact['title']}</td>
                                                <td>{$contact['full_name']}</td>
                                                <td>{$contact['email']}</td>
                                                <td>{$contact['company']}</td>
                                                <td>
                                                    <div class='type-action-container'>
                                                        <span class='type-container {$typeClass}'>{$contact['type']}</span>
                                                        <a class='view-link' href='fullview.php?id={$contact['id']}'>View</a>
                                                    </div>
                                                </td>
                                            </tr>";
                                    }
                                } catch (PDOException $e) {
                                    echo "<tr><td colspan='5'>Error fetching contacts: " . $e->getMessage() . "</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        
    </script>
</body>
</html>
