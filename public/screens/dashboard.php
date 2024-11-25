<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../../php/HTML-base/head.php'; ?>
    <title>Dashboard - Dolphin CRM</title>
    <?php include '../../php/HTML-base/navbar.php'; ?>
    <link rel="stylesheet" href="../css/styles-index.css" />
</head>
<body>

    
    <div class="container mt-5">
        <h1 class="text-center">Dolphin CRM Dashboard</h1>
        
        <div class="text-end my-3">
            <button class="btn btn-primary" onclick="window.location.href='add_contact.php'">Add New Contact</button>
        </div>
        
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
</body>
</html>
