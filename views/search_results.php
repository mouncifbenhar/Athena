<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Athena - Search Tasks</title>
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

        /* Search Filter Bar */
        .search-container {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            margin-bottom: 30px;
        }

        .search-form {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
        }

        .search-form input[type="text"] {
            flex: 2;
            min-width: 200px;
        }

        .search-form select {
            flex: 1;
            min-width: 150px;
        }

        input[type="text"], select {
            padding: 10px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.2s;
        }

        input:focus, select:focus { border-color: #6366f1; }

        .btn-search {
            background-color: #6366f1;
            color: white;
            padding: 10px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }
        .btn-search:hover { background-color: #4f46e5; }

        /* Results Table */
        .table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { background: #f8fafc; padding: 16px; font-size: 0.75rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; }
        td { padding: 16px; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; vertical-align: top; }

        .desc-cell { color: #64748b; font-size: 0.85rem; max-width: 300px; }
        
        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }
        .priority-high { color: #dc2626; background: #fee2e2; }
        .priority-medium { color: #d97706; background: #fef3c7; }
        .priority-low { color: #16a34a; background: #dcfce7; }

        .back-link { display: inline-block; margin-top: 20px; color: #6366f1; text-decoration: none; font-size: 0.9rem; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar__brand">Athena</div>
        <nav>
            <ul class="sidebar__nav">
                <li><a class="sidebar__link" href="index.php?action=dashboard">Dashboard</a></li>
                <li><a class="sidebar__link sidebar__link--active" href="index.php?action=search_tasks">Search Tasks</a></li>
                <li><a class="sidebar__link" href="index.php?action=profile">My Profile</a></li>
                <li><a class="sidebar__link" style="color: #fda4af;" href="index.php?action=logout">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main">
        <div class="header">
            <h1>Search Tasks</h1>
            <p style="color: #64748b;">Find specific tasks across your projects</p>
        </div>

        <div class="search-container">
            <form class="search-form" method="GET" action="index.php">
                <input type="hidden" name="action" value="search_tasks">
                
                <input type="text" name="q" placeholder="Keywords (title, description...)" value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>">
                
                <select name="status">
                    <option value="">All Status</option>
                    <option value="todo" <?php echo ($_GET['status'] ?? '') == 'todo' ? 'selected' : ''; ?>>To Do</option>
                    <option value="in_progress" <?php echo ($_GET['status'] ?? '') == 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
                    <option value="done" <?php echo ($_GET['status'] ?? '') == 'done' ? 'selected' : ''; ?>>Done</option>
                </select>
                
                <select name="priority">
                    <option value="">All Priority</option>
                    <option value="low" <?php echo ($_GET['priority'] ?? '') == 'low' ? 'selected' : ''; ?>>Low</option>
                    <option value="medium" <?php echo ($_GET['priority'] ?? '') == 'medium' ? 'selected' : ''; ?>>Medium</option>
                    <option value="high" <?php echo ($_GET['priority'] ?? '') == 'high' ? 'selected' : ''; ?>>High</option>
                </select>
                
                <select name="project_id">
                    <option value="">All Projects</option>
                    <?php 
                    $projectRepository = new ProjectRepository($db);
                    $projects = $projectRepository->getAllProjects();
                    foreach ($projects as $project): 
                    ?>
                        <option value="<?php echo $project['id']; ?>" 
                            <?php echo ($_GET['project_id'] ?? '') == $project['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($project['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <button type="submit" class="btn-search">Search</button>
            </form>
        </div>

        <div class="table-container">
            <?php if (!empty($tasks)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Assignee</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td style="font-weight: 600; color: #1e1b4b;"><?php echo htmlspecialchars($task['title']); ?></td>
                            <td class="desc-cell"><?php echo htmlspecialchars($task['description']); ?></td>
                            <td>
                                <span style="text-transform: capitalize; font-size: 0.85rem; color: #475569;">
                                    <?php echo str_replace('_', ' ', $task['status']); ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge priority-<?php echo $task['priority']; ?>">
                                    <?php echo ucfirst($task['priority']); ?>
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 24px; height: 24px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: bold; color: #475569;">
                                        <?php echo strtoupper(substr($task['assignee_name'] ?? 'U', 0, 1)); ?>
                                    </div>
                                    <span style="font-size: 0.85rem;"><?php echo htmlspecialchars($task['assignee_name'] ?? 'Unassigned'); ?></span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="padding: 40px; text-align: center; color: #64748b;">
                    <p>No tasks found matching your criteria.</p>
                </div>
            <?php endif; ?>
        </div>

        <a href="index.php?action=dashboard" class="back-link">← Back to Dashboard</a>
    </main>

</body>
</html>