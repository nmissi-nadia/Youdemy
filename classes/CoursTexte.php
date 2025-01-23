<?php
require_once 'Cours.php';
require_once  'Database.php';
class CoursTexte extends Cours {
    private string $contenuTexte;

    public function __construct(
        string $titre, 
        string $description, 
        string $documentation, 
        string $contenuTexte
    ) {
        parent::__construct(); // Appel du constructeur parent
        $this->setTitre($titre);
        $this->setDescription($description);
        $this->setDocumentation($documentation);
        $this->contenuTexte = $contenuTexte;
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
    public function ajouterCours(array $tags): bool {
        $db = Database::getInstance()->getConnection();
        $query = "INSERT INTO cours (titre, description, documentation, idcategorie, idEnseignant) 
                  VALUES (:titre, :description, :documentation, :idcategorie, :idEnseignant)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':titre', $this->titre);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':documentation', $this->documentation);
        $stmt->bindParam(':idcategorie', $this->categorieId);
        $stmt->bindParam(':idEnseignant', $this->enseignantId);

        if ($stmt->execute()) {
            $idCours = $db->lastInsertId();
            $this->associerTags($idCours, $tags);
            return true;
        }
        return false;
    }

    

    // Surcharge de la méthode afficher les détails du cours
    public function afficherCours(): string {
        return parent::afficherCours() . "\nContenu texte : " . $this->contenuTexte;
    }
}
?>
