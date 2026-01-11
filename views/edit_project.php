<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athena - Edit Project</title>
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
        .header { margin-bottom: 30px; }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            max-width: 800px;
        }

        .block__error {
            background-color: #fff1f0;
            color: #d85140;
            padding: 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            border: 1px solid #ffa39e;
        }

        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 0.85rem; font-weight: 600; color: #475569; margin-bottom: 8px; }

        input[type="text"], select, textarea {
            width: 100%;
            padding: 12px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.2s;
        }

        textarea { min-height: 100px; resize: vertical; }
        input:focus, select:focus, textarea:focus { border-color: #6366f1; }

        .btn-update {
            background-color: #6366f1;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }
        .btn-update:hover { background-color: #4f46e5; }

        .section-title { margin: 40px 0 20px; font-size: 1.25rem; font-weight: 700; }

        .member-list { list-style: none; background: white; border-radius: 12px; border: 1px solid #e2e8f0; }
        .member-item {
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f1f5f9;
        }
        .member-item:last-child { border: none; }
        .member-info { font-size: 0.95rem; }
        .member-email { color: #64748b; font-size: 0.85rem; }
        
        .btn-remove {
            color: #dc2626;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 6px;
            background: #fef2f2;
        }
        .btn-remove:hover { background: #fee2e2; }

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
            <h1>Edit Project</h1>
        </div>

        <div class="card">
            <?php if (isset($error)): ?>
                <p class="block__error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <form method="POST" action="index.php?action=update_project">
                <input type="hidden" name="id" value="<?php echo $project['id']; ?>">
                
                <div class="form-group">
                    <label>Project Name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($project['name']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description"><?php echo htmlspecialchars($project['description']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Project Leader</label>
                    <select name="leader_id" required>
                        <?php foreach ($allUsers as $user): ?>
                            <option value="<?php echo $user['id']; ?>" <?php echo ($user['id'] == $project['leader_id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($user['username']); ?> (<?php echo htmlspecialchars($user['email']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Status</label>
                    <select name="is_active">
                        <option value="1" <?php echo ($project['is_active']) ? 'selected' : ''; ?>>Active</option>
                        <option value="0" <?php echo (!$project['is_active']) ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-update">Update Project</button>
            </form>
        </div>

        <h3 class="section-title">Project Members</h3>
        <div class="card" style="padding: 0;">
            <?php if (!empty($project['members'])): ?>
                <ul class="member-list">
                    <?php foreach ($project['members'] as $member): ?>
                        <li class="member-item">
                            <div class="member-info">
                                <strong><?php echo htmlspecialchars($member['username']); ?></strong>
                                <div class="member-email"><?php echo htmlspecialchars($member['email']); ?></div>
                            </div>
                            <?php if ($member['id'] != $project['leader_id']): ?>
                                <a class="btn-remove" href="index.php?action=remove_member&project_id=<?php echo $project['id']; ?>&user_id=<?php echo $member['id']; ?>">
                                    Remove
                                </a>
                            <?php else: ?>
                                <span style="font-size: 0.75rem; color: #6366f1; font-weight: 700; text-transform: uppercase;">Leader</span>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p style="padding: 20px; color: #64748b;">No members assigned to this project.</p>
            <?php endif; ?>
        </div>

        <a href="index.php?action=admin_projects" class="back-link">← Back to Projects</a>
    </main>

</body>
</html>