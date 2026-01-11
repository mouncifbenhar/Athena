<?php
class CommentService {
    private $commentRepository;

    public function __construct($commentRepository) {
        $this->commentRepository = $commentRepository;
    }

    public function addComment($taskId, $userId, $content) {
        if (empty(trim($content))) {
            throw new Exception("Comment cannot be empty");
        }
        return $this->commentRepository->addComment($taskId, $userId, $content);
    }

    public function getTaskComments($taskId) {
        return $this->commentRepository->getTaskComments($taskId);
    }

    public function deleteComment($commentId, $userId, $userRole) {
        $comment = $this->commentRepository->getCommentById($commentId);
        
        if (!$comment) {
            throw new Exception("Comment not found");
        }

        if (!$comment->canDelete($userId, $userRole)) {
            throw new Exception("You don't have permission to delete this comment");
        }

        return $this->commentRepository->deleteComment($commentId, $userId);
    }
}
?>