<!DOCTYPE html>
<html>
<head>
    <title>Create Sprint</title>
</head>
<body>
    <h1>Create New Sprint</h1>
    
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="POST" action="index.php?action=save_sprint">
        <input type="hidden" name="project_id" value="<?php echo $projectId; ?>">
        
        <div>
            <label>Sprint Name:</label>
            <input type="text" name="name" required>
        </div>
        
        <div>
            <label>Start Date:</label>
            <input type="date" name="start_date" required>
        </div>
        
        <div>
            <label>End Date:</label>
            <input type="date" name="end_date" required>
        </div>
        
        <div>
            <label>Goal/Description:</label>
            <textarea name="goal" rows="4"></textarea>
        </div>
        
        <button type="submit">Create Sprint</button>
    </form>
    
    <a href="index.php?action=project_sprints&project_id=<?php echo $projectId; ?>">Back to Sprints</a>
</body>
</html>