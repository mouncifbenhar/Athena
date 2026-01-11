<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athena - Manage Projects</title>
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

        
        .main { flex: 1; padding: 40px; }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

       
        .btn-create {
            background-color: #6366f1;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
        }
        .btn-create:hover { background-color: #4f46e5; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2); }

      
        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { background: #f8fafc; padding: 16px; font-size: 0.85rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; }
        td { padding: 16px; border-bottom: 1px solid #f1f5f9; font-size: 0.95rem; }

       
        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge--active { background: #dcfce7; color: #166534; }
        .badge--inactive { background: #f1f5f9; color: #475569; }

        .action-group { display: flex; gap: 15px; }
        .link-edit { color: #6366f1; text-decoration: none; font-weight: 500; }
        .link-toggle { color: #64748b; text-decoration: none; font-weight: 500; }
        .link-edit:hover, .link-toggle:hover { text-decoration: underline; }

        .back-link { display: inline-block; margin-top: 20px; color: #6366f1; text-decoration: none; font-size: 0.9rem; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar__brand">Athena</div>
        <nav>
            <ul class="sidebar__nav">
                <li><a class="sidebar__link" href="index.php?action=admin_dashboard">Dashboard</a></li>
                <li><a class="sidebar__link" href="index.php?action=admin_users">Manage Users</a></li>
                <li><a class="sidebar__link sidebar__link--active" href="index.php?action=admin_projects">Manage Projects</a></li>
                <li><a class="sidebar__link" href="index.php?action=logout">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main">
        <div class="header">
            <div>
                <h1>Manage Projects</h1>
                <p style="color: #64748b;">Oversee and track all active initiatives</p>
            </div>
            <a href="index.php?action=create_project" class="btn-create">+ Create New Project</a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Project Name</th>
                        <th>Lead</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($projects as $project): ?>
                    <tr>
                        <td style="color: #94a3b8;">#<?php echo $project['id']; ?></td>
                        <td><strong><?php echo htmlspecialchars($project['name']); ?></strong></td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 24px; height: 24px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: bold;">
                                    <?php echo strtoupper(substr($project['leader_name'], 0, 1)); ?>
                                </div>
                                <?php echo htmlspecialchars($project['leader_name']); ?>
                            </div>
                        </td>
                        <td>
                            <span class="badge <?php echo $project['is_active'] ? 'badge--active' : 'badge--inactive'; ?>">
                                <?php echo $project['is_active'] ? 'Active' : 'Inactive'; ?>
                            </span>
                        </td>
                        <td>
                            <div class="action-group">
                                <a class="link-edit" href="index.php?action=edit_project&id=<?php echo $project['id']; ?>">Edit</a>
                                <a class="link-toggle" href="index.php?action=toggle_project&id=<?php echo $project['id']; ?>">
                                    <?php echo $project['is_active'] ? 'Deactivate' : 'Activate'; ?>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <a href="index.php?action=admin_dashboard" class="back-link">← Back to Dashboard</a>
    </main>

</body>
</html>