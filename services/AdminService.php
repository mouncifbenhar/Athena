<?php
class AdminService {
    private $userRepository;
    private $db;

    public function __construct($userRepository, $db) {
        $this->userRepository = $userRepository;
        $this->db = $db;
    }

    public function getStatistics() {
        $stats = [];
        
        $stats['users'] = $this->countTable('users');
        $stats['projects'] = $this->countTable('projects');
        $stats['sprints'] = $this->countTable('sprints');
        $stats['tasks'] = $this->countTable('tasks');
        $stats['active_projects'] = $this->countTable('projects', 'is_active = TRUE');
        
        return $stats;
    }

    private function countTable($table, $condition = '1=1') {
        $query = "SELECT COUNT(*) as count FROM $table WHERE $condition";
        $stmt = $this->db->query($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    public function toggleUserStatus($userId) {
        return $this->userRepository->toggleUserStatus($userId);
    }

    public function updateUserRole($userId, $role) {
        if (!in_array($role, ['admin', 'project_leader', 'team_member'])) {
            throw new AdminException("Invalid role");
        }

        return $this->userRepository->updateRole($userId, $role);
    }

    public function getSystemLogs($limit = 50) {
        $query = "SELECT l.*, u.username FROM logs l 
                  LEFT JOIN users u ON l.user_id = u.id 
                  ORDER BY l.created_at DESC 
                  LIMIT :limit";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function handleIssue($issueId, $action, $adminId) {
        $query = "UPDATE issues SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $action);
        $stmt->bindParam(':id', $issueId);
        
        $success = $stmt->execute();
        
        if ($success) {
            $this->logAction($adminId, "Handled issue #$issueId with action: $action");
        }
        
        return $success;
    }

    private function logAction($userId, $action) {
        $query = "INSERT INTO logs (user_id, action) VALUES (:user_id, :action)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':action', $action);
        $stmt->execute();
    }
}

class AdminException extends Exception {}