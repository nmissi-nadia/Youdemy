<?php
require_once  'Database.php';

class Cours {
    private int $id;
    private string $titre;
    private string $description;
    private string $documentation;
    private string $cheminVideo;
    private int $categorieId;
    private int $enseignantId;
    private string $dateCreation;
    private $baseDeDonnees;

    public function __construct() {
        $this->baseDeDonnees = Database::getInstance()->getConnection();
    }

    // GETTERS
    public function getId(): int {
        return $this->id;
    }

    public function getTitre(): string {
        return $this->titre;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getDocumentation(): string {
        return $this->documentation;
    }

    public function getCheminVideo(): string {
        return $this->cheminVideo;
    }

    public function getCategorieId(): int {
        return $this->categorieId;
    }

    public function getEnseignantId(): int {
        return $this->enseignantId;
    }

    public function getDateCreation(): string {
        return $this->dateCreation;
    }

    // SETTERS
    public function setTitre(string $titre): void {
        $this->titre = $titre;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function setDocumentation(string $documentation): void {
        $this->documentation = $documentation;
    }

    public function setCheminVideo(string $cheminVideo): void {
        $this->cheminVideo = $cheminVideo;
    }

    public function setCategorieId(int $categorieId): void {
        $this->categorieId = $categorieId;
    }

    public function setEnseignantId(int $enseignantId): void {
        $this->enseignantId = $enseignantId;
    }

    // MÉTHODES

    // Récupérer tous les cours
    public function obtenirTousLesCours() {
        try {
            $requete = "SELECT c.idcours, c.titre, c.description, c.documentation, c.path_vedio AS chemin_video, c.dateCreation, 
                        cat.categorie AS nom_categorie, CONCAT(u.prenom, ' ', u.nom) AS enseignant
                        FROM cours c
                        INNER JOIN categorie cat ON c.idcategorie = cat.idcategorie
                        INNER JOIN user u ON c.idEnseignant = u.iduser
                        ORDER BY c.dateCreation DESC";
            $stmt = $this->baseDeDonnees->prepare($requete);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des cours : " . $e->getMessage());
        }
    }

    // Récupérer un cours par ID
    public function obtenirCoursParId(int $id) {
        try {
            $requete = "SELECT c.idcours, c.titre, c.description, c.documentation, c.path_vedio AS chemin_video, c.dateCreation, 
                        cat.categorie AS nom_categorie, CONCAT(u.prenom, ' ', u.nom) AS enseignant
                        FROM cours c
                        INNER JOIN categorie cat ON c.idcategorie = cat.idcategorie
                        INNER JOIN user u ON c.idEnseignant = u.iduser
                        WHERE c.idcours = :id";
            $stmt = $this->baseDeDonnees->prepare($requete);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération du cours : " . $e->getMessage());
        }
    }

    // Ajouter un nouveau cours
    public function ajouterCours(string $titre, string $description, string $documentation, string $cheminVideo, int $categorieId, int $enseignantId) {
        try {
            $requete = "INSERT INTO cours (titre, description, documentation, path_vedio, idcategorie, idEnseignant) 
                        VALUES (:titre, :description, :documentation, :cheminVideo, :categorieId, :enseignantId)";
            $stmt = $this->baseDeDonnees->prepare($requete);
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':documentation', $documentation);
            $stmt->bindParam(':cheminVideo', $cheminVideo);
            $stmt->bindParam(':categorieId', $categorieId, PDO::PARAM_INT);
            $stmt->bindParam(':enseignantId', $enseignantId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout du cours : " . $e->getMessage());
        }
    }

    // Supprimer un cours
    public function supprimerCours(int $id) {
        try {
            $requete = "DELETE FROM cours WHERE idcours = :id";
            $stmt = $this->baseDeDonnees->prepare($requete);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression du cours : " . $e->getMessage());
        }
    }

    // Récupérer les cours d'un enseignant
    public function obtenirCoursParEnseignant(int $idEnseignant) {
        try {
            $requete = "SELECT c.idcours, c.titre, c.description, c.documentation, c.path_vedio AS chemin_video, c.dateCreation, 
                        cat.categorie AS nom_categorie
                        FROM cours c
                        INNER JOIN categorie cat ON c.idcategorie = cat.idcategorie
                        WHERE c.idEnseignant = :idEnseignant
                        ORDER BY c.dateCreation DESC";
            $stmt = $this->baseDeDonnees->prepare($requete);
            $stmt->bindParam(':idEnseignant', $idEnseignant, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des cours de l'enseignant : " . $e->getMessage());
        }
    }
}
