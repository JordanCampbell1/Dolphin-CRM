<title>Add New User - Dolphin CRM</title>
<link rel="stylesheet" href="css/newuser.css">
<script src="js/createUser.js"></script>


<div class="content-header">
    <h1>Add New User</h1>
</div>
<div class="form-container">
    <form id="new-user-form" method="POST">
        <div class="form-group">
            <label for="first-name">First Name</label>
            <input type="text" id="first-name" name="first_name" required>
        </div>
        <div class="form-group">
            <label for="last-name">Last Name</label>
            <input type="text" id="last-name" name="last_name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select id="role" name="role" required>
                <option value="Member">Member</option>
                <option value="Admin">Admin</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="submit">Save</button>
        </div>
    </form>
</div>

