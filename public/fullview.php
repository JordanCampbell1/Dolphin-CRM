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
//comment
// SQL query
$sql = "
    SELECT 
        c.id, c.title, c.firstname, c.lastname, c.email, c.telephone, c.company, c.type, 
        c.assigned_to, c.created_by,c.created_at,c.updated_at
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
            'assigned_to' => $row['assigned_to'],
            'created_by' => $row['created_by'],
            'created_at' => $row['created_at'],
             'updated_at'=>$row['updated_at']
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
            background-color: #D3D3D3; /* Slight grey color */
            flex-grow: 1; /* Take remaining space */
            min-height: calc(100vh - 60px); /* Full height minus the header height */
            box-sizing: border-box; /* Include padding in height calculation */
        }

        #avatar{
            width: 48px;
            margin-right: 4px;

        }

        /* Container for the form and content */
        .container {
            max-width: 1200px;
            margin: 8px;
        }
        
        #detail{
            margin-left: 48px;
        }
        

        #conatiner-details {
            background-color: white;
            border: solid grey 1px;
            border-radius: 4px;
            margin: 8px;
            padding: 16px;
        }

        .content-margin_dif{
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Two equal columns */
            gap: 40px; /* Space between columns */
        }
        .label {
            margin: 8px;
            color: grey;
            margin-bottom: 4px; /* Space between label and content */
        }

        .field {
            display: flex;
            flex-direction: column; /* Stack label above content */
        }
        .content-margin{
            margin: 8px;
        }

        #container-notes-list{
            background-color: white;
            border: solid grey 1px;
            border-radius: 4px;
            margin: 32px;
            padding: 16px;
        }
        #container-addnotes{
            background-color: white;
            border: solid grey 1px;
            border-radius: 4px;
            margin-left: 32px;
        }
        

        #top_or_head {
            display: flex;
            justify-content: space-between; /* Place items at the edges of the container */
            align-items: center; /* Align vertically */
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
        #button-group {
            margin-left: 40px;
            display: flex;
            gap: 10px; /* Space between buttons */
        }

        .btn-assign, .btn-switch {
            padding: 10px;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px; /* Space between icon and text */
        }
        .btn-assign{
            background-color: green;
        }
        .btn-switch{
            background-color: orange;
        }
        .btn-assign img{
            width: 16px;
        }
        .btn-switch img{
            width: 16px;
        }

        #content_container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
        }
        textarea {
            width: 1200px; /* Adjust the width as needed */
            height: 150px; /* Adjust the height as needed */
            font-size: 16px; /* Optional: Set the font size */
            padding: 10px; /* Optional: Add padding for better appearance */
            border: 1px solid #ccc; /* Optional: Border styling */
            border-radius: 8px; /* Optional: Rounded corners */
            resize: none; /* Optional: Prevent resizing */
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
                <?php if ($contact): 
                    
                    ?>
                    <div id="top_or_head">   
                        <div id="top-left">
                            <h2><img id="avatar" src="images/Avatar.png" alt="user avatar"><?php echo htmlspecialchars($contact['title'].'.'.$contact['firstname'] . ' ' . $contact['lastname']); ?></h2>
                            <div id="detail">
                                <p>Created on  <?php echo htmlspecialchars($contact['created_at']); ?> by <?php echo htmlspecialchars($contact['created_by']); ?> </p>
                                <p>Updated on <?php echo htmlspecialchars($contact['updated_at']); ?></p>
                            </div>
                        </div>
                        <div id="button-group">
                            <?php
                                // Determine the next type based on the current type
                                $nextType = ($contact['type'] === 'sales lead') ? 'support' : 'sales lead';
                                
                            ?>
                            <button type="button" class="btn-assign" onclick="assigntome(<?php echo htmlspecialchars($contact['id']); ?>)">
                                <img src="images/palm-of-hand.png"> Assign to me
                            </button>
                            <button type="button" class="btn-switch" onclick="switchrole(<?php echo htmlspecialchars($contact['id']); ?>, '<?php echo htmlspecialchars($contact['type']); ?>')">
                                <img src="images/swap.png"> Switch to <?php echo htmlspecialchars($nextType); ?>
                            </button>
                        </div>
                    </div>
                    <div id="conatiner-details">
                        <div class="content-margin_dif">
                            <div class="field">
                                <p class="label">Email</p>
                                <p><?php echo htmlspecialchars($contact['email']); ?></p>
                            </div>
                            <div class="field">
                                <p class="label">Telephone</p>
                                <p><?php echo htmlspecialchars($contact['telephone']); ?></p>
                            </div>
                            <div class="field">
                                <p class="label">Company</p>
                                <p><?php echo htmlspecialchars($contact['company']); ?></p>
                            </div>
                            <div class="field">
                                <p class="label">Assigned To</p>
                                <p><?php echo htmlspecialchars($contact['assigned_to']); ?></p>
                            </div>
                        </div>
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
                            </form>
                            <button type="submit" class="btn">Add Note</button>
                        </div>

                    </div>
            </div>
        </div>
    </div>
    <script>
       
        function assigntome(contactId) {
        console.log('Assign to me clicked', contactId);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../php/setup/assigntome.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            console.log('Ready state:', this.readyState, 'Status:', this.status);
            if (this.readyState === 4) {
                console.log('Response:', this.responseText);
                if (this.status === 200) {
                    alert("Contact assigned successfully");
                    location.reload();
                } else {
                    alert("Error assigning contact: " + this.responseText);
                }
            }
        };
        xhr.send("id=" + encodeURIComponent(contactId));
    }

    function switchrole(contactId, currentType) {
        console.log('Switch role clicked', contactId, currentType);
        var newType = (currentType === 'sales lead') ? 'support' : 'sales lead';
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../php/setup/switchrole.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            console.log('Ready state:', this.readyState, 'Status:', this.status);
            if (this.readyState === 4) {
                console.log('Response:', this.responseText);
                if (this.status === 200) {
                    alert("Role switched successfully");
                    location.reload();
                } else {
                    alert("Error switching role: " + this.responseText);
                }
            }
        };
        xhr.send("id=" + encodeURIComponent(contactId) + "&type=" + encodeURIComponent(newType));
    }
</script>
    
</body>
</html>
