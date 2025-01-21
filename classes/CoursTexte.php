<?php
require_once 'Cours.php';

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
        string $cheminVideo, // Non utilisé ici
        int $categorieId,
        int $enseignantId
    ): bool {
        try {
            $this->setTitre($titre);
            $this->setDescription($description);
            $this->setDocumentation($documentation);
            $this->setCategorieId($categorieId);
            $this->setEnseignantId($enseignantId);

            // Logique pour ajouter un cours texte
            $requete = "INSERT INTO cours (titre, description, documentation, path_vedio, idcategorie, idEnseignant)
                        VALUES (:titre, :description, :documentation, NULL, :categorieId, :enseignantId)";
            $stmt = $this->baseDeDonnees->prepare($requete);
            $stmt->bindParam(':titre', $this->getTitre());
            $stmt->bindParam(':description', $this->getDescription());
            $stmt->bindParam(':documentation', $this->getDocumentation());
            $stmt->bindParam(':categorieId', $this->getCategorieId(), PDO::PARAM_INT);
            $stmt->bindParam(':enseignantId', $this->getEnseignantId(), PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout du cours texte : " . $e->getMessage());
        }
    }

    // Surcharge de la méthode afficher les détails du cours
    public function afficherCours(): string {
        return parent::afficherCours() . "\nContenu texte : " . $this->contenuTexte;
    }
}
?>
