<?php


    class Etudiant extends User {


            public static function inscription($prenom, $email, $motDePasse) {
                $bd = BaseDeDonnees::getInstance();
                $pdo = $bd->getConnexion();
        
                $stmt = $pdo->prepare("INSERT INTO user (prenom, email, password, role) VALUES (?, ?, ?, 'etudiant')");
                $motDePasseHashe = password_hash($motDePasse, PASSWORD_DEFAULT);
                return $stmt->execute([$prenom, $email, $motDePasseHashe]);
            }
    }

    

?>