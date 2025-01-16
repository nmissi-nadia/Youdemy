<?php

require_once './User.php';
require_once './Database.php';

    class Etudient extends User {

            public static function login($email, $password) {
                $db = Database::getInstance();
                $pdo = $db->getConnection();
        
                $stmt = $pdo->prepare("SELECT * FROM user WHERE email = ? AND role = 'etudiant'");
                $stmt->execute([$email]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if ($user && password_verify($password, $user['password'])) {
                    $etudiant = new self();
                    $etudiant->setPrenom($user['prenom']);
                    $etudiant->setEmail($user['email']);
                    $etudiant->setRole($user['role']);
                    $etudiant->setStatus($user['status']);
                    return $etudiant;
                } else {
                    return null;
                }
            }

    }

?>