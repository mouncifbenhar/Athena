<?php
class CommentRepository {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addComment($taskId, $userId, $content) {
        $query = "INSERT INTO comments (task_id, user_id, content) 
                  VALUES (:task_id, :user_id, :content)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':task_id', $taskId);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':content', $content);
        return $stmt->execute();
    }

    public function getTaskComments($taskId) {
        $query = "SELECT c.*, u.username 
                  FROM comments c
                  JOIN users u ON c.user_id = u.id
                  WHERE c.task_id = :task_id
                  ORDER BY c.created_at ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':task_id', $taskId);
        $stmt->execute();
        
        $comments = [];
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($results as $row) {
            $comments[] = new Comment(
                $row['id'],
                $row['task_id'],
                $row['user_id'],
                $row['content'],
                $row['created_at'],
                $row['username']
            );
        }
        
        return $comments;
    }

    public function deleteComment($commentId, $userId) {
        $query = "DELETE FROM comments WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $commentId);
        $stmt->bindParam(':user_id', $userId);
        return $stmt->execute();
    }

    public function getCommentById($commentId) {
        $query = "SELECT c.*, u.username 
                  FROM comments c
                  JOIN users u ON c.user_id = u.id
                  WHERE c.id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $commentId);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            return new Comment(
                $row['id'],
                $row['task_id'],
                $row['user_id'],
                $row['content'],
                $row['created_at'],
                $row['username']
            );
        }
        
        return null;
    }

    public function getConnection() {
        return $this->db;
    }
}
?>