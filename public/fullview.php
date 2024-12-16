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
    <link rel="stylesheet" href="css/fullview.css">
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
