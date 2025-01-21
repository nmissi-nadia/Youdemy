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
            // Validation des données
            $this->setTitre($titre);
            $this->setDescription($description);
            $this->setLienVideo($cheminVideo);
            $this->setCategorieId($categorieId);
            $this->setEnseignantId($enseignantId);
    
            // Insertion dans la table cours
            $requeteCours = "INSERT INTO cours (titre, description, documentation, path_vedio, idcategorie, idEnseignant)
                             VALUES (:titre, :description, :documentation, :path_vedio, :categorieId, :enseignantId)";
            $stmtCours = $this->baseDeDonnees->prepare($requeteCours);
            $stmtCours->bindValue(':titre', $this->getTitre());
            $stmtCours->bindValue(':description', $this->getDescription());
            $stmtCours->bindValue(':documentation', $documentation ?: null, PDO::PARAM_STR);
            $stmtCours->bindValue(':path_vedio', $this->getLienVideo());
            $stmtCours->bindValue(':categorieId', $this->getCategorieId(), PDO::PARAM_INT);
            $stmtCours->bindValue(':enseignantId', $this->getEnseignantId(), PDO::PARAM_INT);
    
            if (!$stmtCours->execute()) {
                throw new Exception("Erreur lors de l'insertion dans la table 'cours'.");
            }
    
            // Récupération de l'ID du cours nouvellement inséré
            $idCours = $this->baseDeDonnees->lastInsertId();
            var_dump($tags);
            // Insertion des tags associés au cours
            if (!empty($tags)) {
                $requeteTag = "INSERT INTO tag_cours (idcours, idtag) VALUES (:idCours, :idTag)";
                $stmtTag = $this->baseDeDonnees->prepare($requeteTag);
    
                foreach ($tags as $idTag) {
                    $stmtTag->bindValue(':idCours', $idCours, PDO::PARAM_INT);
                    $stmtTag->bindValue(':idTag', $idTag, PDO::PARAM_INT);
    
                    if (!$stmtTag->execute()) {
                        throw new Exception("Erreur lors de l'insertion dans la table 'tag_cours' pour le tag ID : $idTag.");
                    }
                }
            }
    
            return true;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout du cours et des tags : " . $e->getMessage());
        }
    }
    
}
?>
