<?php 
session_start();
include 'db_connect.php'; 

// Only Admins can access this page
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') { 
    die("Access Denied: You do not have permission to view this page."); 
}

// Handle User Deletion
if(isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    // Prevent admin from deleting themselves
    if($id != $_SESSION['user_id']) {
        $conn->query("DELETE FROM users WHERE user_id = $id");
        header("Location: users.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users | GonPreaks</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .badge { padding: 5px 10px; border-radius: 5px; font-size: 0.8rem; background: rgba(56, 189, 248, 0.2); color: #38bdf8; }
        .search-bar { padding: 10px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: white; border-radius: 5px; }
        select.search-bar option { background: #0f172a; color: white; }
    </style>
</head>
<body>
    <div style="margin-left: 260px; padding: 20px;">
        <h2 style="color: #38bdf8;"><i class="fas fa-users-cog"></i> User Management</h2>

        <div class="glass-card" style="margin-bottom: 20px;">
            <h3>Add New Employee</h3>
            <form action="save_user.php" method="POST" style="display: flex; gap: 10px; margin-top: 15px; flex-wrap: wrap;">
                <input type="text" name="full_name" placeholder="Full Name" required class="search-bar" style="flex: 1;">
                <input type="text" name="username" placeholder="Username" required class="search-bar" style="flex: 1;">
                <input type="password" name="password" placeholder="Password" required class="search-bar" style="flex: 1;">
                
                <select name="role" class="search-bar" style="flex: 1;">
                    <option value="Cashier">Cashier</option>
                    <option value="Restocker">Restocker</option>
                    <option value="Account Manager">Account Manager</option>
                    <option value="Driver">Driver</option>
                    <option value="Admin">Admin</option>
                </select>
                
                <button type="submit" class="btn-pos" style="padding: 10px 25px;">Add User</button>
            </form>
        </div>

        <div class="glass-card">
            <h3>Staff Directory</h3>
            <table class="table-glass" style="width: 100%; margin-top: 15px;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th style="text-align: center;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $res = $conn->query("SELECT * FROM users ORDER BY role ASC");
                    while($u = $res->fetch_assoc()):
                    ?>
                    <tr>
                        <td><strong><?php echo $u['full_name']; ?></strong></td>
                        <td><?php echo $u['username']; ?></td>
                        <td><span class="badge"><?php echo $u['role']; ?></span></td>
                        <td style="text-align: center;">
                            <?php if($u['user_id'] != $_SESSION['user_id']): ?>
                                <a href="users.php?delete_id=<?php echo $u['user_id']; ?>" 
                                   onclick="return confirm('Remove this user?')" 
                                   style="color:#ef4444; text-decoration:none;">
                                   <i class="fas fa-trash-alt"></i> Remove
                                </a>
                            <?php else: ?>
                                <small style="opacity: 0.5;">(You)</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>