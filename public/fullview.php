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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Details</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .note { margin-bottom: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        .note small { display: block; color: #666; margin-top: 5px; }
    </style>
</head>
<body>
    <h1>Contact Details</h1>
    <?php if ($contact): ?>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($contact['firstname'] . ' ' . $contact['lastname']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($contact['email']); ?></p>
        <p><strong>Telephone:</strong> <?php echo htmlspecialchars($contact['telephone']); ?></p>
        <p><strong>Company:</strong> <?php echo htmlspecialchars($contact['company']); ?></p>
        <p><strong>Type:</strong> <?php echo htmlspecialchars($contact['type']); ?></p>
        <p><strong>Created By:</strong> <?php echo htmlspecialchars($contact['created_by']); ?></p>
        <p><strong>Created At:</strong> <?php echo htmlspecialchars($contact['created_at']); ?></p>
        <p><strong>Updated At:</strong> <?php echo htmlspecialchars($contact['updated_at']); ?></p>

        <h2>Notes</h2>
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
</body>
</html>
