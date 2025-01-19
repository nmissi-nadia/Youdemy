<?php
require_once 'User.php';
require_once 'Database.php';

class Admin extends User {
    public function obtenirTousLesUtilisateurs() {
        $bd = Database::getInstance();
        $pdo = $bd->getConnection();

        $stmt = $pdo->query("SELECT * FROM user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenirEnseignantsEnAttente() {
        $bd = Database::getInstance();
        $pdo = $bd->getConnection();

        $stmt = $pdo->query("SELECT * FROM user WHERE role = 'Enseignant' AND status = 'pending'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function activerUtilisateur($id) {
        $bd = Database::getInstance();
        $pdo = $bd->getConnection();

        $stmt = $pdo->prepare("UPDATE user SET status = 'active' WHERE iduser = ?");
        return $stmt->execute([$id]);
    }

    public function suspendreUtilisateur($id) {
        $bd = Database::getInstance();
        $pdo = $bd->getConnection();

        $stmt = $pdo->prepare("UPDATE user SET status = 'suspended' WHERE iduser = ?");
        return $stmt->execute([$id]);
    }

    public function supprimerUtilisateur($id) {
        $bd = Database::getInstance();
        $pdo = $bd->getConnection();

        $stmt = $pdo->prepare("DELETE FROM user WHERE iduser = ?");
        return $stmt->execute([$id]);
    }

    public function obtenirNombreTotalCours() {
        $bd = Database::getInstance();
        $pdo = $bd->getConnection();

        $stmt = $pdo->query("SELECT COUNT(*) as total FROM course");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function obtenirNombreTotalEtudiants() {
        $bd = Database::getInstance();
        $pdo = $bd->getConnection();

        $stmt = $pdo->query("SELECT COUNT(*) as total FROM user WHERE role = 'etudiant'");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function obtenirNombreEnseignantsEnAttente() {
        $bd = Database::getInstance();
        $pdo = $bd->getConnection();
    
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM user WHERE role = 'Enseignant' AND status = 'en attente'");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    
        public function obtenirCoursAvecPlusEtudiants() {
            $bd = Database::getInstance();
            $pdo = $bd->getConnection();

            $stmt = $pdo->query("SELECT cours.titre, COUNT(inscription.id) as total FROM cours 
                                JOIN inscription ON cours.idcours = inscription.idcours 
                                GROUP BY cours.idcours 
                                ORDER BY total DESC 
                                LIMIT 1");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        }

        public function obtenirTop3Enseignants() {
            $bd = Database::getInstance();
            $pdo = $bd->getConnection();
        
            $stmt = $pdo->query("SELECT user.nom, user.prenom, COUNT(cours.idcours) as total FROM user 
                                 JOIN cours ON user.iduser = cours.idEnseignant 
                                 WHERE user.role = 'Enseignant' 
                                 GROUP BY user.iduser 
                                 ORDER BY total DESC 
                                 LIMIT 3");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
}
?>