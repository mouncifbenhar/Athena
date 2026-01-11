<?php
class ProjectRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($name, $description, $leaderId) {
        $query = "INSERT INTO projects (name, description, leader_id) VALUES (:name, :description, :leader_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':leader_id', $leaderId);
        return $stmt->execute();
    }

    public function findById($projectId) {
        $query = "SELECT * FROM projects WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $projectId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   

    public function getProjectsByMember($userId) {
        $query = "SELECT p.* FROM projects p 
                  JOIN project_members pm ON p.id = pm.project_id 
                  WHERE pm.user_id = :user_id AND p.is_active = TRUE";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addMember($projectId, $userId) {
        $query = "INSERT INTO project_members (project_id, user_id) VALUES (:project_id, :user_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':project_id', $projectId);
        $stmt->bindParam(':user_id', $userId);
        return $stmt->execute();
    }

    public function toggleProjectStatus($projectId) {
        $query = "UPDATE projects SET is_active = NOT is_active WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $projectId);
        return $stmt->execute();
    }

    public function getConnection() {
        return $this->db;
    }
    public function getAllProjects() {
    $query = "SELECT p.*, u.username as leader_name 
              FROM projects p
              JOIN users u ON p.leader_id = u.id
              ORDER BY p.created_at DESC";
    $stmt = $this->db->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getProjectById($projectId) {
    $query = "SELECT p.*, u.username as leader_name 
              FROM projects p
              JOIN users u ON p.leader_id = u.id
              WHERE p.id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $projectId);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function getProjectMembers($projectId) {
    $query = "SELECT u.id, u.username, u.email 
              FROM users u
              JOIN project_members pm ON u.id = pm.user_id
              WHERE pm.project_id = :project_id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':project_id', $projectId);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function updateProject($projectId, $name, $description, $leaderId) {
    $query = "UPDATE projects 
              SET name = :name, description = :description, 
                  leader_id = :leader_id
              WHERE id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':leader_id', $leaderId);
    $stmt->bindParam(':id', $projectId);
    return $stmt->execute();
}
}