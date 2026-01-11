<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athena - Dashboard</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 260px;
            background-color: #1e1b4b;
            color: white;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .sidebar__brand { font-size: 1.5rem; font-weight: 700; margin-bottom: 40px; color: #818cf8; }
        .sidebar__nav { list-style: none; }
        .sidebar__link {
            display: block;
            padding: 12px 15px;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 8px;
            transition: 0.3s;
        }
        .sidebar__link:hover, .sidebar__link--active { background-color: #312e81; color: white; }

        .main { flex: 1; padding: 40px; overflow-y: auto; }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
        }

        .notification-toast {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        .notification-toast h3 { font-size: 0.9rem; color: #1e40af; margin-bottom: 5px; }
        .notification-list { list-style: none; font-size: 0.85rem; }

        .section-title { margin: 30px 0 15px; font-size: 1.25rem; font-weight: 700; }

        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { background: #f8fafc; padding: 16px; font-size: 0.75rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; }
        td { padding: 16px; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; }

        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }
        .status--done { background: #dcfce7; color: #166534; }
        .status--progress { background: #fef9c3; color: #854d0e; }
        .status--todo { background: #f1f5f9; color: #475569; }

        .priority--high { color: #dc2626; font-weight: 700; }
        .priority--medium { color: #d97706; font-weight: 700; }
        .priority--low { color: #16a34a; font-weight: 700; }

        .action-link {
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            color: #4f46e5;
        }
        .action-link:hover { text-decoration: underline; }

        .btn-primary {
            background-color: #6366f1;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar__brand">Athena</div>
        <nav>
            <ul class="sidebar__nav">
                <li><a class="sidebar__link sidebar__link--active" href="index.php?action=dashboard">Dashboard</a></li>
                <li><a class="sidebar__link" href="index.php?action=search_tasks">Search Tasks</a></li>
                <li><a class="sidebar__link" href="index.php?action=profile">My Profile</a></li>
                <?php if ($_SESSION['user_role'] == 'admin'): ?>
                    <li><a class="sidebar__link" href="index.php?action=admin_dashboard">Admin Panel</a></li>
                <?php endif; ?>
                <li><a class="sidebar__link" style="margin-top: 20px; color: #fda4af;" href="index.php?action=logout">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main">
        <header class="header">
            <div>
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
                <p style="color: #64748b;">Role: <span style="text-transform: capitalize; font-weight: 600;"><?php echo $_SESSION['user_role']; ?></span></p>
            </div>
            <a href="index.php?action=create_task" class="btn-primary">+ New Task</a>
        </header>

        <?php if (!empty($notifications)): ?>
            <div class="notification-toast">
                <h3>Recent Notifications</h3>
                <ul class="notification-list">
                    <?php foreach ($notifications as $notification): ?>
                        <li>• <?php echo htmlspecialchars($notification['message']); ?> <span style="color: #64748b; font-size: 0.75rem;">(<?php echo date('H:i', strtotime($notification['created_at'])); ?>)</span></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <h2 class="section-title">My Tasks</h2>

        <div class="table-container">
            <?php if (!empty($tasks)): ?>
                <table>
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
                                <a href="index.php?action=view_task&id=<?php echo $task['id']; ?>" class="action-link" style="color: #1e293b; font-weight: 600;">
                                    <?php echo htmlspecialchars($task['title']); ?>
                                </a>
                            </td>
                            <td><span style="color: #64748b;"><?php echo htmlspecialchars($task['sprint_name'] ?? 'No Sprint'); ?></span></td>
                            <td>
                                <span class="badge <?php 
                                    echo $task['status'] == 'done' ? 'status--done' : 
                                        ($task['status'] == 'in_progress' ? 'status--progress' : 'status--todo');
                                ?>">
                                    <?php echo ucfirst(str_replace('_', ' ', $task['status'])); ?>
                                </span>
                            </td>
                            <td>
                                <span class="priority--<?php echo $task['priority']; ?>">
                                    ● <?php echo ucfirst($task['priority']); ?>
                                </span>
                            </td>
                            <td style="color: #64748b; font-size: 0.8rem;"><?php echo date('M j, Y', strtotime($task['created_at'])); ?></td>
                            <td>
                                <?php if ($task['status'] == 'todo'): ?>
                                    <a class="action-link" href="index.php?action=update_task_status&id=<?php echo $task['id']; ?>&status=in_progress">▶ Start</a>
                                <?php elseif ($task['status'] == 'in_progress'): ?>
                                    <a class="action-link" style="color: #16a34a;" href="index.php?action=update_task_status&id=<?php echo $task['id']; ?>&status=done">✓ Complete</a>
                                <?php endif; ?>
                                
                                <?php if ($task['assignee_id'] == $_SESSION['user_id'] || $_SESSION['user_role'] == 'admin'): ?>
                                    <span style="color: #e2e8f0; margin: 0 8px;">|</span>
                                    <a class="action-link" style="color: #64748b;" href="index.php?action=edit_task&id=<?php echo $task['id']; ?>">Edit</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="padding: 40px; text-align: center; color: #64748b;">
                    <p>No tasks assigned to you.</p>
                    <a href="index.php?action=create_task" class="action-link" style="margin-top: 10px; display: inline-block;">Create your first task →</a>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>