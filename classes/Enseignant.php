<?php
    require_once 'User.php';
    require_once 'Database.php';
    

    class Enseignant extends User {

        public static function login($email, $password) {
            $db = Database::getInstance();
            $pdo = $db->getConnection();
    
            $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ? AND role = 'Enseignant'");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($user && password_verify($password, $user['password'])) {
                $enseignant = new self();
                $enseignant->setPrenom($user['prenom']);
                $enseignant->setEmail($user['email']);
                $enseignant->setRole($user['role']);
                $enseignant->setStatus($user['status']);
                return $enseignant;
            } else {
                return null;
            }
        }

    }

?>