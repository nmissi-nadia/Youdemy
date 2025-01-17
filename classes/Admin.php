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
}
?>