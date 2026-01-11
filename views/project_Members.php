<!DOCTYPE html>
<html>
<head>
    <title>Project Members</title>
</head>
<body>
    <h1>Members of: <?php echo $project['name']; ?></h1>
    
    <ul>
        <?php foreach ($members as $member): ?>
            <li>
                <?php echo $member['username']; ?> (<?php echo $member['email']; ?>)
                <?php if ($member['id'] == $project['leader_id']): ?>
                    <strong> - Project Leader</strong>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    
    <a href="index.php?action=dashboard">← Back to Dashboard</a>
</body>
</html>