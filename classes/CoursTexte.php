<?php
require_once 'Cours.php';
require_once  'Database.php';
class CoursTexte extends Cours {
    private string $contenuTexte;

    public function __construct(
        string $titre, 
        string $description, 
        string $documentation, 
        string $contenuTexte, 
        int $categorieId, 
        int $enseignantId
    ) {
        parent::__construct(); // Appel du constructeur parent
        $this->setTitre($titre);
        $this->setDescription($description);
        $this->setDocumentation($documentation);
        $this->contenuTexte = $contenuTexte;
        $this->setCategorieId($categorieId);
        $this->setEnseignantId($enseignantId);
    }

    // Getter pour le contenu texte
    public function getContenuTexte(): string {
        return $this->contenuTexte;
    }

    // Setter pour le contenu texte
    public function setContenuTexte(string $contenuTexte): void {
        $this->contenuTexte = $contenuTexte;
    }

    // Surcharge de la méthode ajouterCours pour inclure le contenu texte
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
            // Début de la transaction
            $this->baseDeDonnees->beginTransaction();
    
            // Préparer les données du cours
            $this->setTitre($titre);
            $this->setDescription($description);
            $this->setDocumentation($documentation);
            $this->setCategorieId($categorieId);
            $this->setEnseignantId($enseignantId);
    
            // Insérer le cours dans la base de données
            $requeteCours = "INSERT INTO cours (titre, description, documentation, path_vedio, idcategorie, idEnseignant)
                             VALUES (:titre, :description, :documentation, NULL, :categorieId, :enseignantId)";
            $stmtCours = $this->baseDeDonnees->prepare($requeteCours);
            $stmtCours->bindValue(':titre', $this->getTitre());
            $stmtCours->bindValue(':description', $this->getDescription());
            $stmtCours->bindValue(':documentation', $this->getDocumentation());
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
            // Annulation de la transaction en cas d'erreur
            $this->baseDeDonnees->rollBack();
            throw new Exception("Erreur lors de l'ajout du cours texte et des tags : " . $e->getMessage());
        }
    }
    

    // Surcharge de la méthode afficher les détails du cours
    public function afficherCours(): string {
        return parent::afficherCours() . "\nContenu texte : " . $this->contenuTexte;
    }
}
?>
