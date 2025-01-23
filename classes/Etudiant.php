<?php
require_once 'User.php';
require_once 'Database.php';

    class Etudiant extends User {
        public function __construct($id, $nom, $prenom, $email,$role ,$passwordHash, $status) {
            parent::__construct($id, $nom, $prenom, $email,'etudiant',$passwordHash ,$status);
        }

     // Visualisation du catalogue des cours
     public  function afficherCatalogueDesCours() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT c.idcours, c.titre, c.description, u.nom AS enseignant, c.dateCreation
                               FROM cours c
                               JOIN user u ON c.idEnseignant = u.iduser");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Recherche de cours par mots-clés
    public static function rechercherCours($keyword) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT c.idcours, c.titre, c.description, u.nom AS enseignant, c.dateCreation
                               FROM cours c
                               JOIN user u ON c.idEnseignant = u.iduser
                               WHERE c.titre LIKE :keyword OR c.description LIKE :keyword");
        $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Inscription à un cours
    public function inscrireCours($idCours) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO enrollments (idcours, iduser) VALUES (:idcours, :iduser)");
        $stmt->bindParam(':idcours', $idCours, PDO::PARAM_INT);
        $stmt->bindParam(':iduser', $this->id, PDO::PARAM_INT);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Obtenir les cours rejoints par l'étudiant
    public function mesCours() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT c.idcours, c.titre, c.description, c.dateCreation
                               FROM cours c
                               JOIN enrollments e ON c.idcours = e.idcours
                               WHERE e.iduser = :iduser");
        $stmt->bindParam(':iduser', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>