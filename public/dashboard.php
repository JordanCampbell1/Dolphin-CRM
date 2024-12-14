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
    }    catch (PDOException $e) {
    // Handle connection errors
    die("Database connection failed: " . $e->getMessage());
    }


    ?>
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
            background-color: #ffffff;
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

        #content_container {
            background-color: #ffffff;
            border-radius: 8px;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff; /* White background for table */
            border: 1px solid #d3d3d3; /* Grey border for the table */
            border-radius: 8px; /* Rounded corners for the table */
            overflow: hidden; /* Ensure the content inside respects the rounded corners */
        }

        /* Table header with rounded corners at the top */
        thead {
            background-color: #d3d3d3; /* Light grey background for header */
            color: black; /* Text color for the header */
            border-top-left-radius: 8px; /* Rounded top left corner */
            border-top-right-radius: 8px; /* Rounded top right corner */
        }

        /* Add border-radius to the table rows, columns, and header for consistency */
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #d3d3d3; /* Grey border for table cells */
        }

        /* Optional: To ensure no overlapping borders between the header and the body */
        tbody tr:first-child th,
        tbody tr:first-child td {
            border-top: none;
        }

        /* Add this to ensure rounded corners are respected inside the table container */
        .table-container {
            margin: 16px;
            background-color: #fff;
            overflow: hidden; /* Ensures content respects rounded corners */
        }


        #filtertxt {
            font-weight: bold; /* Make it bold */
            color: black; /* Optional: Set color to grey */
            margin-right: 10px; /* Add spacing between "Filter By:" and options */
        }

        /* Filter container styling */
        #filter-container {
            margin-bottom: 20px;
            margin-left: 10px;
            margin-top: 16px;
        }

        /* Default filter option styles */
        .filter-option {
            margin-right: 10px;
            cursor: pointer;
            color: grey; /* Default grey text */
            text-decoration: none; /* No underline */
            padding: 5px 10px;
            position: relative;
        }

        /* Highlighted filter option */
        .filter-option.selected {
            color: #6a0dad; /* Bluish-purple text color */
        }

        /* Add underline for the selected filter option */
        .filter-option.selected::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 2px;
            background-color: #6a0dad; /* Bluish-purple underline */
            transform: scaleX(1);
            transition: transform 0.3s ease-in-out;
        }

        /* Optional hover effect */
        .filter-option:hover {
            color: #6a0dad; /* Hover color matches selected state */
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
                        <span id="filtertxt">Filter By:</span>
                        <span class="filter-option" data-filter="all">All</span>
                        <span class="filter-option" data-filter="Sales Leads">Sales Leads</span>
                        <span class="filter-option" data-filter="Support">Support</span>
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
                        </thead>
                            <tbody id="contacts-table-body">
                                <!-- PHP to Fetch and Display Contacts -->
                                <?php
                                // Assuming $conn is your PDO database connection
                                try {
                                    $stmt = $conn->query("SELECT title, CONCAT(firstname, ' ', lastname) AS full_name, email, company, type, assigned_to FROM Contacts");
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
                                catch (Exception $e) {
                                    $e->getMessage() . "";
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
                    // Remove 'selected' class from all options
                    filterOptions.forEach(opt => opt.classList.remove("selected"));
                    
                    // Add 'selected' class to the clicked option
                    option.classList.add("selected");

                    // Filter the table based on the selected option
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