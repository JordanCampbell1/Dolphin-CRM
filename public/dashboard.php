<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../php/HTML-base/head.php'; ?>
    <title>Dashboard - Dolphin CRM</title>
    <link rel="stylesheet" href="css/styles-index.css" />
    
    <style>
        /* Ensure the page layout covers full height */
        html, body {
            height: 100%;
            margin: 0;
        }

        /* Container for the entire page */
        .main-container {
            display: flex;
            min-height: 100vh; /* Full viewport height */
            width: 100%;
        }

        /* Top header with sticky position */
        .top {
            position: sticky;
            top: 0;
            z-index: 1000; /* Ensure it stays above other elements */
            background-color: #fff;
            height: 60px; /* Match the header height */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Optional shadow */
        }

        /* Sidebar styles */
        .side {
            background-color: #111;
            height: 100%; /* Full height */
            flex: 0 0 250px; /* Fixed width for sidebar */
            position: relative;
            padding-top: 60px; /* Space for the sticky header */
        }

        /* Content section */
        .content {
            padding: 40px;
            background-color: #8f9092; /* Slight grey color */
            flex-grow: 1; /* Take remaining space */
            min-height: calc(100vh - 60px); /* Full height minus the header height */
            box-sizing: border-box; /* Include padding in height calculation */
        }

        /* Container for the form and content */
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Flex layout for header (h1 and button inline) */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            background-color: #0056b3;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #004494;
        }

        #content_container{
            background-color: #ffffff;
            border-radius: 8px;
        }

        /* Table container with white background */
        .table-container {
            background-color: #fff;
            border: 2px solid;
            border-color: grey;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #33f;
            color: white;
        }

        /* Filter container styling */
        #filter-container {
            margin-bottom: 20px;
        }

        .filter-option {
            margin-right: 10px;
            cursor: pointer;
            color: #0056b3;
            text-decoration: underline;
        }

        .filter-option:hover {
            color: #004494;
        }

    </style>
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
                <!-- Header with h1 and button inline -->
                <div class="header">
                    <h1>Dashboard</h1>
                    <button class="btn" onclick="window.location.href='newContact.php'">Add New Contact</button>
                </div>
                <div id="content_container">
                    <!-- Filter Container -->
                    <div id="filter-container">
                        <span>Filter By:</span>
                        <span class="filter-option" data-filter="all">All</span>
                        <span class="filter-option" data-filter="Sales Leads">Sales Leads</span>
                        <span class="filter-option" data-filter="Support">Support</span>
                        <span class="filter-option" data-filter="assigned">Assigned to me</span>
                    </div>

                    <!-- Table wrapped in a white background container -->
                    <div class="table-container">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Title</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Company</th>
                                    <th>Type of Contact</th>
                                </tr>
                            </thead>
                            <tbody id="contacts-table-body">
                                <!-- PHP to Fetch and Display Contacts -->
                                <?php
                                // Assuming $conn is your PDO database connection
                                try {
                                    $stmt = $conn->prepare("SELECT title, CONCAT(firstname, ' ', lastname) AS full_name, email, company, type, assigned_to FROM Contacts");
                                    $stmt->execute();
                                    $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($contacts as $contact) {
                                        echo "<tr data-type='{$contact['type']}' data-assigned='{$contact['assigned_to']}'>
                                                <td>{$contact['title']}</td>
                                                <td>{$contact['full_name']}</td>
                                                <td>{$contact['email']}</td>
                                                <td>{$contact['company']}</td>
                                                <td>{$contact['type']}</td>
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
        document.addEventListener("DOMContentLoaded", () => {
            const filterOptions = document.querySelectorAll(".filter-option");
            const tableBody = document.getElementById("contacts-table-body");
            const userId = "<?php echo $_SESSION['user_id']; ?>"; // Assuming user ID is stored in session

            filterOptions.forEach(option => {
                option.addEventListener("click", () => {
                    const filter = option.getAttribute("data-filter");
                    filterTable(filter);
                });
            });

            function filterTable(filter) {
                const rows = tableBody.querySelectorAll("tr");
                rows.forEach(row => {
                    const type = row.getAttribute("data-type");
                    const assignedTo = row.getAttribute("data-assigned");

                    if (filter === "all") {
                        row.style.display = "";
                    } else if (filter === "assigned") {
                        if (assignedTo === userId) {
                            row.style.display = "";
                        } else {
                            row.style.display = "none";
                        }
                    } else {
                        if (type === filter) {
                            row.style.display = "";
                        } else {
                            row.style.display = "none";
                        }
                    }
                });
            }
        });
    </script>

</body>
</html>