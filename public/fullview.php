<?php
// Database connection
$host = "localhost";
$dbname = "dolphin_crm";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Fetch contact ID from request (GET or POST)
$contactId = $_GET['id'] ?? null;

if (!$contactId) {
    die('No contact ID provided.');
}

// SQL query
$sql = "
    SELECT 
        c.id, c.title, c.firstname, c.lastname, c.email, c.telephone, c.company, c.type, 
        c.created_at, c.updated_at,
        u.firstname AS created_by_firstname, u.lastname AS created_by_lastname,
        n.comment AS note_comment, n.created_at AS note_created_at
    FROM Contacts c
    LEFT JOIN Users u ON c.created_by = u.id
    LEFT JOIN Notes n ON c.id = n.contact_id
    WHERE c.id = :id
";

$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $contactId]);
$results = $stmt->fetchAll();

if (empty($results)) {
    die('No contact found with the given ID.');
}

// Process the results
$contact = null;
$notes = [];

foreach ($results as $row) {
    if (!$contact) {
        $contact = [
            'id' => $row['id'],
            'title' => $row['title'],
            'firstname' => $row['firstname'],
            'lastname' => $row['lastname'],
            'email' => $row['email'],
            'telephone' => $row['telephone'],
            'company' => $row['company'],
            'type' => $row['type'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at'],
            'created_by' => $row['created_by_firstname'] . ' ' . $row['created_by_lastname']
        ];
    }
    if (!empty($row['note_comment'])) {
        $notes[] = [
            'comment' => $row['note_comment'],
            'created_at' => $row['note_created_at']
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../php/HTML-base/head.php'; ?>
    <title>Contact Details - Dolphin CRM</title>
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

        #conatiner-details{
            background-color: white;
            border: solid grey 1px;
            border-radius: 4px;
            margin: 16px;
        }
        
        .content-margin{
            margin: 8px;
        }

        #container-notes-list{
            background-color: white;
            border: solid grey 1px;
            border-radius: 4px;
            margin: 16px;
        }
        #container-addnotes{
            background-color: white;
            border: solid grey 1px;
            border-radius: 4px;
            margin: 16px;
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
            padding: 20px;
        }


        /* Table styles */
        .note {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .note small {
            display: block;
            color: #666;
            margin-top: 5px;
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
                <?php if ($contact): ?>
                    <h2><?php echo htmlspecialchars($contact['title'].'.'.$contact['firstname'] . ' ' . $contact['lastname']); ?></h2>
                    <p>Created on  <?php echo htmlspecialchars($contact['created_at']); ?></p> by <?php echo htmlspecialchars($contact['created_by']); ?> </p>
                    <p>Updated on <?php echo htmlspecialchars($contact['updated_at']); ?></p>

                    <div id="conatiner-details">
                        <div class="content-margin">
                            <p class="label">Email</p>
                            <p><?php echo htmlspecialchars($contact['email']); ?></p>

                            <p class="label">Telephone</p>
                            <p><?php echo htmlspecialchars($contact['telephone']); ?></p>

                            <p class="label">Company</p>
                            <p><?php echo htmlspecialchars($contact['company']); ?></p>

                            <p class="label">Assigned To</p>
                            <p><?php echo htmlspecialchars($contact['created_by']); ?></p>
                        
                        </div>
                    </div>
                    <div id="container-notes-list">
                        <div class="content-margin">
                            <h5>Notes</h5>

                            <?php if (!empty($notes)): ?>
                                <?php foreach ($notes as $note): ?>
                                    <div class="note">
                                        <p><?php echo nl2br(htmlspecialchars($note['comment'])); ?></p>
                                        <small>Created at: <?php echo htmlspecialchars($note['created_at']); ?></small>
                                    </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                   <p>No notes available for this contact.</p>
                                <?php endif; ?>
                                <?php else: ?>
                                    <p>Contact not found.</p>
                                <?php endif; ?>
                        </div>
                    </div>
                    <div id="container-addnotes">
                        <div class="content-margin">
                            <h6>Add a note about <?php echo htmlspecialchars($contact['firstname']); ?></h6>
                            <form action="add_note.php" method="POST" id="note-form">
                                <textarea name="note_comment" placeholder="Enter your note here..." onkeypress="submitOnEnter(event)"></textarea>
                                <button type="submit" class="btn">Add Note</button>
                            </form>
                        </div>

                    </div>
            </div>
        </div>
    </div>
    <script>
        function submitOnEnter(event) {
            if (event.key === 'Enter' && !event.shiftKey) { // Check if "Enter" key is pressed without Shift
                event.preventDefault(); // Prevent the default "Enter" key behavior (new line)
                document.getElementById('note-form').submit(); // Submit the form
            }
        }
    </script>

</body>
</html>
