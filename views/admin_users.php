<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
</head>
<body>
    <h1>Manage Users</h1>
    
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['role']; ?></td>
                <td><?php echo $user['is_active'] ? 'Active' : 'Inactive'; ?></td>
                <td>
                    <a href="index.php?action=admin_toggle_user&user_id=<?php echo $user['id']; ?>">
                        <?php echo $user['is_active'] ? 'Deactivate' : 'Activate'; ?>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    
    <a href="index.php?action=dashboard">Back to Dashboard</a>
</body>
</html>