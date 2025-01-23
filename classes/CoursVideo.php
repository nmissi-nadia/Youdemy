<?php
require_once 'Cours.php';
require_once  'Database.php';

class CoursVideo extends Cours {
    private string $lienVideo;

    public function __construct(
        string $titre, 
        string $description, 
        string $documentation, 
        string $lienVideo, 
        int $categorieId, 
        int $enseignantId
    ) {
        parent::__construct(); // Appel du constructeur parent
        $this->baseDeDonnees = Database::getInstance()->getConnection(); // Initialisation
        $this->setTitre($titre);
        $this->setDescription($description);
        $this->setDocumentation($documentation);
        $this->lienVideo = $lienVideo;
        $this->setCategorieId($categorieId);
        $this->setEnseignantId($enseignantId);
    }

    // Getter pour le lien vidéo
    public function getLienVideo(): string {
        return $this->lienVideo;
    }

    // Setter pour le lien vidéo
    public function setLienVideo(string $lienVideo): void {
        $this->lienVideo = $lienVideo;
    }

    // Surcharge de la méthode ajouterCours pour inclure le lien vidéo
    public function ajouterCours(array $tags): bool {
        $db = Database::getInstance()->getConnection();
        $query = "INSERT INTO cours (titre, description, path_vedio, idcategorie, idEnseignant) 
                  VALUES (:titre, :description, :path_vedio, :idcategorie, :idEnseignant)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':titre', $this->titre);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':path_vedio', $this->pathVideo);
        $stmt->bindParam(':idcategorie', $this->categorieId);
        $stmt->bindParam(':idEnseignant', $this->enseignantId);

        if ($stmt->execute()) {
            $idCours = $db->lastInsertId();
            $this->associerTags($idCours, $tags);
            return true;
        }
        return false;
    }
    
}
?>
