<!DOCTYPE html>
<html>
<head>
    <title>Create Project</title>
</head>
<body>
    <h1>Create New Project</h1>
    
    <form method="POST" action="index.php?action=save_project">
        <div>
            <label>Project Name:</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>Description:</label>
            <textarea name="description"></textarea>
        </div>
        <div>
            <label>Leader ID:</label>
            <input type="number" name="leader_id" required>
        </div>
        <button type="submit">Create Project</button>
    </form>
    
    <a href="index.php?action=admin_projects">Back to Projects</a>
</body>
</html>