<?php
class SprintRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($projectId, $name, $startDate, $endDate, $goal) {
        if (checkSprintConflict($startDate, $endDate, $projectId)) {
            throw new Exception("Sprint dates conflict with existing sprints");
        }

        $query = "INSERT INTO sprints (project_id, name, start_date, end_date, goal) 
                  VALUES (:project_id, :name, :start_date, :end_date, :goal)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':project_id', $projectId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':start_date', $startDate);
        $stmt->bindParam(':end_date', $endDate);
        $stmt->bindParam(':goal', $goal);
        return $stmt->execute();
    }

    public function getSprintsByProject($projectId) {
        $query = "SELECT * FROM sprints WHERE project_id = :project_id ORDER BY start_date";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':project_id', $projectId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($sprintId) {
        $query = "SELECT * FROM sprints WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $sprintId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createSprint($projectId, $name, $startDate, $endDate, $goal) {
    $query = "INSERT INTO sprints (project_id, name, start_date, end_date, goal) 
              VALUES (:project_id, :name, :start_date, :end_date, :goal)";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':project_id', $projectId);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':start_date', $startDate);
    $stmt->bindParam(':end_date', $endDate);
    $stmt->bindParam(':goal', $goal);
    return $stmt->execute();
}



public function getSprintDetails($sprintId) {
    $query = "SELECT s.*, p.name as project_name 
              FROM sprints s
              JOIN projects p ON s.project_id = p.id
              WHERE s.id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $sprintId);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function getAllSprintsForUser($userId, $userRole) {
    if ($userRole === 'admin') {
        
        $query = "SELECT s.*, p.name as project_name 
                  FROM sprints s
                  JOIN projects p ON s.project_id = p.id
                  ORDER BY s.start_date DESC";
        $stmt = $this->db->query($query);
    } else {
       
        $query = "SELECT s.*, p.name as project_name 
                  FROM sprints s
                  JOIN projects p ON s.project_id = p.id
                  JOIN project_members pm ON p.id = pm.project_id
                  WHERE pm.user_id = :user_id
                  ORDER BY s.start_date DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
    }
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    public function getConnection() {
        return $this->db;
    }

}