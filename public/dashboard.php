<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../php/HTML-base/head.php';
        try {
            $host = "localhost";
            $dbname = "dolphin_crm";
            $username = "root";
            $password = "";

            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT id, firstname, lastname, email, role, created_at FROM Users";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    ?>
    <title>Dashboard - Dolphin CRM</title>
    <link rel="stylesheet" href="css/dashboard.css" />
</head>
    <!-- Embed user ID in a data attribute -->
<body data-user-id="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>">
    <!-- Other HTML content -->


<script src='js/dashboard.js'></script>
    <div class="content">
        <div class="container">
            <div class="header">
                <h1>Dashboard</h1>
                <button class="btn" onclick="window.location.href='newContact.php'">Add New Contact</button>
            </div>
            <div id="content_container">
                <div id="filter-container">
                    <span id="filtertxt"><img src="../public/images/filter.png" alt="home ico"> Filter By:</span>
                    <span class="filter-option" data-filter="all">All</span>
                    <span class="filter-option" data-filter="sales lead">Sales Leads</span>
                    <span class="filter-option" data-filter="support">Support</span>
                    <span class="filter-option" data-filter="assigned">Assigned to me</span>
                </div>
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

</body>
</html>