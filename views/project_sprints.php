<!DOCTYPE html>
<html>
<head>
    <title>Project Sprints</title>
</head>
<body>
    <h1>Sprints for: <?php echo $project['name']; ?></h1>
    
    <?php if (App::hasRole('project_leader') && $_SESSION['user_id'] == $project['leader_id']): ?>
        <a href="index.php?action=create_sprint&project_id=<?php echo $projectId; ?>">Create New Sprint</a>
    <?php endif; ?>
    
    <?php if (!empty($sprints)): ?>
        <table border="1">
            <tr>
                <th>Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Goal</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($sprints as $sprint): ?>
                <tr>
                    <td><?php echo $sprint['name']; ?></td>
                    <td><?php echo $sprint['start_date']; ?></td>
                    <td><?php echo $sprint['end_date']; ?></td>
                    <td><?php echo $sprint['goal']; ?></td>
                    <td>
                        <a href="index.php?action=view_sprint&id=<?php echo $sprint['id']; ?>">View</a>
                        <?php if (App::hasRole('project_leader') && $_SESSION['user_id'] == $project['leader_id']): ?>
                            | <a href="index.php?action=edit_sprint&id=<?php echo $sprint['id']; ?>">Edit</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No sprints yet for this project.</p>
    <?php endif; ?>
    
    <br>
    <a href="index.php?action=dashboard">Back to Dashboard</a>
</body>
</html>