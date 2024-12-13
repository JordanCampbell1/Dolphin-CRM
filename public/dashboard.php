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

        /* Table container with white background */
        .table-container {
            background-color: #fff;
            padding: 20px;
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
                        <tbody>
                            <!-- PHP to Fetch and Display Contacts -->
                            <?php
                            // Assuming $conn is your PDO database connection
                            try {
                                $stmt = $conn->prepare("SELECT title, CONCAT(firstname, ' ', lastname) AS full_name, email, company, type FROM Contacts");
                                $stmt->execute();
                                $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($contacts as $contact) {
                                    echo "<tr>
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

</body>
</html>
