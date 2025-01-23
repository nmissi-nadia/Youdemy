<?php
require_once 'Database.php';

class Cours {
    protected int | null $id;
    protected string | null $titre;
    protected string | null $description;
    protected string | null $documentation;
    protected string | null $cheminVideo;
    protected string | null $dateCreation;
    protected $baseDeDonnees;

    public function __construct($id,$titre, $description, $documentation, $cheminVideo) {
        $this->id=$id;
        $this->titre = $titre;
        $this->description = $description;
        $this->documentation = $documentation;
        $this->cheminVideo = $cheminVideo;
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
   
    public function modifierCours(int $id, string $titre, string $description, string $documentation, string $pathVedio) {
        try {
            $requete = "UPDATE cours SET titre = :titre, description = :description, 
                        documentation = :documentation, path_vedio = :path_vedio WHERE idcours = :id";
            $stmt = $this->baseDeDonnees->prepare($requete);
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':documentation', $documentation);
            $stmt->bindParam(':path_vedio', $pathVedio);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la mise à jour du cours : " . $e->getMessage());
        }
    }
    
    public function obtenirCoursParId(int $id) {
        try {
            $requete = "
                SELECT c.idcours, c.titre, c.description, c.documentation, c.path_vedio AS chemin_video, 
                       c.dateCreation, cat.categorie AS nom_categorie, 
                       CONCAT(u.prenom, ' ', u.nom) AS enseignant,
                       COUNT(e.iduser) AS nombre_etudiants_inscrits
                FROM cours c
                INNER JOIN categorie cat ON c.idcategorie = cat.idcategorie
                INNER JOIN user u ON c.idEnseignant = u.iduser
                LEFT JOIN enrollments e ON c.idcours = e.idcours
                WHERE c.idcours = :id
                GROUP BY c.idcours, c.titre, c.description, c.documentation, c.path_vedio, 
                         c.dateCreation, cat.categorie, u.prenom, u.nom
            ";
            $stmt = $this->baseDeDonnees->prepare($requete);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération du cours : " . $e->getMessage());
        }
    }
    

   // Ajouter un nouveau cours avec des tags
    public function ajouterCours(array $tags,$categorieId,$enseignantId) {
        try {
            $requete = "INSERT INTO cours (titre, description, documentation, path_vedio, idcategorie, idEnseignant) 
                        VALUES (:titre, :description, :documentation, :path_vedio, :idcategorie, :idEnseignant)";
            $stmt = $this->baseDeDonnees->prepare($requete);
            $stmt->bindParam(':titre', $this->titre);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':documentation', $this->documentation);
            $stmt->bindParam(':path_vedio', $this->pathVideo);
            $stmt->bindParam(':idcategorie', $categorieId);
            $stmt->bindParam(':idEnseignant', $enseignantId);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout du cours : " . $e->getMessage());
        }
    }


    // Supprimer un cours
    public function supprimerCours(int $id) {
        try {
            // Commencer une transaction pour garantir l'intégrité des données
            $requeteTags = "DELETE FROM tag_cours WHERE idcours = :id";
            $stmtTags = $this->baseDeDonnees->prepare($requeteTags);
            $stmtTags->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtTags->execute();
            $requeteCours = "DELETE FROM cours WHERE idcours = :id";
            $stmtCours = $this->baseDeDonnees->prepare($requeteCours);
            $stmtCours->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtCours->execute();
            
            return true; // Si tout s'est bien passé
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


    public function obtenirTousLesTagsCours($coursid) {
        try {
            $requete = "
                SELECT t.idtag, t.tag AS nom_tag
                FROM tag t
                INNER JOIN tag_cours ct ON t.idtag = ct.idtag
                WHERE ct.idcours = :idcours
                ORDER BY t.tag ASC
            ";
            $stmt = $this->baseDeDonnees->prepare($requete);
            $stmt->bindParam(':idcours', $coursid, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des tags du cours : " . $e->getMessage());
        }
    }
    // recherche par mot clé
    public function rechercherCours(string $motCle) {
        try {
            $requete = "
                SELECT c.idcours, c.titre, c.description, c.documentation, c.path_vedio AS chemin_video, 
                       c.dateCreation, cat.categorie AS nom_categorie, 
                       CONCAT(u.prenom, ' ', u.nom) AS enseignant
                FROM cours c
                INNER JOIN categorie cat ON c.idcategorie = cat.idcategorie
                INNER JOIN user u ON c.idEnseignant = u.iduser
                WHERE c.titre LIKE :motCle OR c.description LIKE :motCle
                ORDER BY c.dateCreation DESC
            ";
            $stmt = $this->baseDeDonnees->prepare($requete);
            $motCle = "%" . $motCle . "%";
            $stmt->bindParam(':motCle', $motCle, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la recherche des cours : " . $e->getMessage());
        }
    }
    public function getPaginatedCourses(int $offset, int $limit): array {
        try {
            $requete = "SELECT c.idcours, c.titre, c.description, ca.categorie
                        FROM cours c
                        JOIN categorie ca ON c.idcategorie = ca.idcategorie
                        LIMIT :offset, :limit";
            $stmt = $this->baseDeDonnees->prepare($requete);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
    
            // Retourner les résultats sous forme de tableau associatif
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des cours paginés : " . $e->getMessage());
        }
    }
    
    public function countTotalCourses(): int {
        try {
            $requete = "SELECT COUNT(*) AS total FROM cours";
            $stmt = $this->baseDeDonnees->prepare($requete);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors du comptage des cours : " . $e->getMessage());
        }
    }
    protected function associerTags(int $idCours, array $tags) {
        $db = Database::getInstance()->getConnection();
        $query = "INSERT INTO tag_cours (idcours, idtag) VALUES (:idcours, :idtag)";
        foreach ($tags as $tag) {
            $stmt = $db->prepare($query);
            $stmt->bindParam(':idcours', $idCours);
            $stmt->bindParam(':idtag', $tag);
            $stmt->execute();
        }
    }  

}