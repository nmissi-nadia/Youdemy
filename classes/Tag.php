<?php
    require_once 'Database.php';
    
    class Tag {
        private $id;
        private $nom;
        private $database;
    
        public function __construct($nom) {
            $this->nom = $nom;
            $this->database = Database::getInstance()->getConnection();
        }   
    
        // Getters
        public function getId() {
            return $this->id;
        }
    
        public function getNom() {
            return $this->nom;
        }
    
        // Setters
        public function setNom($nom) {
            $this->nom = $nom;
        }
    
        // Récupérer tous les tags
        public function allTags() {
            try {
                $sql = "SELECT T.idtag, T.tag, COUNT(CT.id_course) AS course_count 
                        FROM tag T 
                        LEFT JOIN courses_tags CT ON T.idtag = CT.id_tag
                        GROUP BY T.idtag, T.tag";
                $stmt = $this->database->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la récupération des tags : " . $e->getMessage());
            }
        }
    
        // Ajouter un tag
        public function ajoutTag($nom) {
            try {
                $sql = "INSERT INTO tag (tag) VALUES (:nom)";
                $stmt = $this->database->prepare($sql);
                $stmt->bindParam(":nom", $nom, PDO::PARAM_STR);
                return $stmt->execute();
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de l'ajout du tag : " . $e->getMessage());
            }
        }
    
        // Supprimer un tag
        public function supprimeTag($id) {
            try {
                $sql = "DELETE FROM tag WHERE idtag = :id";
                $stmt = $this->database->prepare($sql);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                return $stmt->execute();
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la suppression du tag : " . $e->getMessage());
            }
        }
    
        // Mettre à jour un tag
        public function ModifeTag($id, $nom) {
            try {
                $sql = "UPDATE tag SET tag = :nom WHERE idtag = :id";
                $stmt = $this->database->prepare($sql);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->bindParam(":nom", $nom, PDO::PARAM_STR);
                return $stmt->execute();
            } catch (PDOException $e) {
                throw new Exception("Erreur lors de la mise à jour du tag : " . $e->getMessage());
            }
        }
    
    
    }
    
?>