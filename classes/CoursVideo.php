<?php
require_once 'Cours.php';

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
    public function ajouterCours(
        string $titre,
        string $description,
        string $documentation,
        string $cheminVideo,
        int $categorieId,
        int $enseignantId
    ): bool {
        try {
            $this->setTitre($titre);
            $this->setDescription($description);
            $this->setDocumentation($documentation);
            $this->setLienVideo($cheminVideo);
            $this->setCategorieId($categorieId);
            $this->setEnseignantId($enseignantId);

            // Logique pour ajouter un cours vidéo
            $requete = "INSERT INTO cours (titre, description, documentation, path_vedio, idcategorie, idEnseignant)
                        VALUES (:titre, :description, :documentation, :cheminVideo, :categorieId, :enseignantId)";
            $stmt = $this->baseDeDonnees->prepare($requete);
            $stmt->bindParam(':titre', $this->getTitre());
            $stmt->bindParam(':description', $this->getDescription());
            $stmt->bindParam(':documentation', $this->getDocumentation());
            $stmt->bindParam(':cheminVideo', $this->getLienVideo());
            $stmt->bindParam(':categorieId', $this->getCategorieId(), PDO::PARAM_INT);
            $stmt->bindParam(':enseignantId', $this->getEnseignantId(), PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout du cours vidéo : " . $e->getMessage());
        }
    }
}
?>
