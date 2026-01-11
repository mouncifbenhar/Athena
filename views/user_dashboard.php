<!DOCTYPE html>
<html>

<head>
    <title>Athena - Dashboard</title>
</head>

<body>
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <p>Role: <?php echo $_SESSION['user_role']; ?></p>
    <li><a href="index.php?action=profile">My Profile</a></li>

    <?php if (!empty($notifications)): ?>
        <h3>Notifications</h3>
        <ul>
            <?php foreach ($notifications as $notification): ?>
                <li><?php echo $notification['message']; ?> (<?php echo $notification['created_at']; ?>)</li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

<h2>My Tasks</h2>

<?php if (!empty($tasks)): ?>
    <table border="1" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Title</th>
                <th>Sprint</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
            <tr>
                <td>
                    <a href="index.php?action=view_task&id=<?php echo $task['id']; ?>">
                        <?php echo htmlspecialchars($task['title']); ?>
                    </a>
                </td>
                <td><?php echo $task['sprint_name'] ?? 'N/A'; ?></td>
                <td>
                    <span style="
                        padding: 2px 6px;
                        border-radius: 3px;
                        background: <?php 
                            echo $task['status'] == 'done' ? '#d4edda' : 
                                  ($task['status'] == 'in_progress' ? '#fff3cd' : '#f8d7da');
                        ?>;
                    ">
                        <?php echo ucfirst($task['status']); ?>
                    </span>
                </td>
                <td>
                    <span style="
                        color: <?php 
                            echo $task['priority'] == 'high' ? 'red' : 
                                  ($task['priority'] == 'medium' ? 'orange' : 'green');
                        ?>;
                    ">
                        <?php echo ucfirst($task['priority']); ?>
                    </span>
                </td>
                <td><?php echo date('Y-m-d', strtotime($task['created_at'])); ?></td>
                <td>
                    <?php if ($task['status'] == 'todo'): ?>
                        <a href="index.php?action=update_task_status&id=<?php echo $task['id']; ?>&status=in_progress">
                            ▶ Start
                        </a>
                    <?php elseif ($task['status'] == 'in_progress'): ?>
                        <a href="index.php?action=update_task_status&id=<?php echo $task['id']; ?>&status=done">
                            ✓ Complete
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($task['assignee_id'] == $_SESSION['user_id'] || App::hasRole('admin') || App::hasRole('project_leader')): ?>
                        | <a href="index.php?action=edit_task&id=<?php echo $task['id']; ?>">Edit</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>You have no tasks assigned. <a href="index.php?action=create_task">Create your first task</a></p>
<?php endif; ?>

    <h3>Actions</h3>
    <ul>
        <li><a href="index.php?action=create_task">Create New Task</a></li>
        <li><a href="index.php?action=search_tasks">Search Tasks</a></li>
        <li><a href="index.php?action=logout">Logout</a></li>
    </ul>
</body>

</html>