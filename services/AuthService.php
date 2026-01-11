<?php
class AuthService {
    private $userRepository;

    public function __construct($userRepository) {
        $this->userRepository = $userRepository;
    }

    public function login($email, $password) {
        
        $user = $this->userRepository->findByEmail($email);
     
         
        if (!$user) {
            throw new AuthException("Invalid credentials");
        }

        if (!$user['is_active']) {
            throw new AuthException("Account is disabled");
        }

        if (!password_verify($password, $user['password'])) {
            throw new AuthException("Invalid credentials");
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['username'] = $user['username'];

        $this->logAction($user['id'], "User logged in");

        return $user;
    }

    public function register($username, $email, $password, $role = 'team_member') {
        if ($this->userRepository->findByEmail($email)) {
            throw new AuthException("Email already exists");
        }

        $success = $this->userRepository->create($username, $email, $password, $role);
        
        if ($success) {
            $this->logAction(null, "New user registered: $username");
        }

        return $success;
    }

    public function logout() {
        if (isset($_SESSION['user_id'])) {
            $this->logAction($_SESSION['user_id'], "User logged out");
        }
        
        session_destroy();
    }

    private function logAction($userId, $action) {
      
        $db = $this->userRepository->getConnection(); 
        $query = "INSERT INTO logs (user_id, action) VALUES (:user_id, :action)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':action', $action);
        $stmt->execute();
    }
}

class AuthException extends Exception {}