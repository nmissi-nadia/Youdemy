<?php


    class Etudiant extends User {

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

            public static function inscription($prenom, $email, $motDePasse) {
                $bd = BaseDeDonnees::getInstance();
                $pdo = $bd->getConnexion();
        
                $stmt = $pdo->prepare("INSERT INTO user (prenom, email, password, role) VALUES (?, ?, ?, 'etudiant')");
                $motDePasseHashe = password_hash($motDePasse, PASSWORD_DEFAULT);
                return $stmt->execute([$prenom, $email, $motDePasseHashe]);
            }
    }

    

?>