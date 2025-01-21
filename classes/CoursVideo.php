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
    public function ajouterCours(
        string $titre,
        string $description,
        string $documentation,
        string $cheminVideo, 
        int $categorieId,
        int $enseignantId,  
        array $tags
    ) {
        try {
            $this->setTitre($titre);
            $this->setDescription($description);
            $this->setLienVideo($cheminVideo);
            $this->setCategorieId($categorieId);
            $this->setEnseignantId($enseignantId);


            // Insertion du cours texte
            $requeteCours = "INSERT INTO cours (titre, description, documentation, path_vedio, idcategorie, idEnseignant)
                             VALUES (:titre, :description, NULL, :path_vedio, :categorieId, :enseignantId)";
            $stmtCours = $this->baseDeDonnees->prepare($requeteCours);
            $stmtCours->bindValue(':titre', $this->getTitre());
            $stmtCours->bindValue(':description', $this->getDescription());
            $stmtCours->bindValue(':path_vedio', $this->getLienVideo());
            $stmtCours->bindValue(':categorieId', $this->getCategorieId(), PDO::PARAM_INT);
            $stmtCours->bindValue(':enseignantId', $this->getEnseignantId(), PDO::PARAM_INT);
            $stmtCours->execute();

            // Récupération de l'ID du cours nouvellement inséré
            $idCours = $this->baseDeDonnees->lastInsertId();

            // Insertion des tags associés au cours
            $requeteTag = "INSERT INTO tag_cours (idcours, idtag) VALUES (:idCours, :idTag)";
            $stmtTag = $this->baseDeDonnees->prepare($requeteTag);
            foreach ($tags as $idTag) {
                $stmtTag->bindParam(':idCours', $idCours, PDO::PARAM_INT);
                $stmtTag->bindParam(':idTag', $idTag, PDO::PARAM_INT);
                $stmtTag->execute();
            }

            // Validation de la transaction
            $this->baseDeDonnees->commit();
            return true;
        } catch (PDOException $e) {
            // Annulation de la transaction
            $this->baseDeDonnees->rollBack();
            throw new Exception("Erreur lors de l'ajout du cours texte et des tags : " . $e->getMessage());
        }
    }
    
}
?>
