<?php
function sanitize($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function formatDate($date) {
    return date('Y-m-d', strtotime($date));
}

function checkSprintConflict($startDate, $endDate, $projectId, $sprintId = null) {
    global $db;
    
    $query = "SELECT COUNT(*) as count FROM sprints 
              WHERE project_id = :project_id 
              AND ((start_date <= :end_date AND end_date >= :start_date) 
              OR (start_date >= :start_date AND start_date <= :end_date))";
    
    if ($sprintId) {
        $query .= " AND id != :sprint_id";
    }
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':project_id', $projectId);
    $stmt->bindParam(':start_date', $startDate);
    $stmt->bindParam(':end_date', $endDate);
    
    if ($sprintId) {
        $stmt->bindParam(':sprint_id', $sprintId);
    }
    
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return $result['count'] > 0;
}

function checkPermissions($userRole, $requiredRole, $resourceOwnerId = null) {
    $roleHierarchy = [
        'admin' => 3,
        'project_leader' => 2,
        'team_member' => 1
    ];
    
    if (!isset($roleHierarchy[$userRole]) || !isset($roleHierarchy[$requiredRole])) {
        return false;
    }
    
    if ($roleHierarchy[$userRole] >= $roleHierarchy[$requiredRole]) {
        return true;
    }
    
    if ($resourceOwnerId && $_SESSION['user_id'] == $resourceOwnerId) {
        return true;
    }
    
    return false;
}