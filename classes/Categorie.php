<?php

include_once 'Database.php';

class Categorie {
    private int $idcategorie;
    private string $categorie;
    private $database;

    public function __construct($categorie) {
        $this->categorie =$categorie;
        $this->database = Database::getInstance()->getConnection();
    }

    // GETTERS
    public function getIdCategorie(): int {
        return $this->idcategorie;
    }

    public function getCategorie(): string {
        return $this->categorie;
    }

    // SETTERS
    public function setCategorie(string $categorie) {
        $this->categorie = $categorie;
    }

    // GET ALL CATEGORIES
    public function allCategories() {
        try {
            $query = "SELECT idcategorie, categorie FROM categorie ORDER BY idcategorie ASC";
            $stmt = $this->database->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des catégories : " . $e->getMessage());
        }
    }

    // GET CATEGORY BY ID
    public function getCategoryById($idcategorie) {
        try {
            $query = "SELECT idcategorie, categorie FROM categorie WHERE idcategorie = :idcategorie";
            $stmt = $this->database->prepare($query);
            $stmt->bindParam(':idcategorie', $idcategorie, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération de la catégorie : " . $e->getMessage());
        }
    }

    // ADD CATEGORY
    public function addCategory(string $categorie) {
        try {
            $query = "INSERT INTO categorie (categorie) VALUES (:categorie)";
            $stmt = $this->database->prepare($query);
            $stmt->bindParam(':categorie', $categorie, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de l'ajout de la catégorie : " . $e->getMessage());
        }
    }

    // DELETE CATEGORY
    public function deleteCategory(int $idcategorie) {
        try {
            $query = "DELETE FROM categorie WHERE idcategorie = :idcategorie";
            $stmt = $this->database->prepare($query);
            $stmt->bindParam(':idcategorie', $idcategorie, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression de la catégorie : " . $e->getMessage());
        }
    }

    // UPDATE CATEGORY
    public function updateCategory(int $idcategorie, string $categorie) {
        try {
            $query = "UPDATE categorie SET categorie = :categorie WHERE idcategorie = :idcategorie";
            $stmt = $this->database->prepare($query);
            $stmt->bindParam(':idcategorie', $idcategorie, PDO::PARAM_INT);
            $stmt->bindParam(':categorie', $categorie, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la mise à jour de la catégorie : " . $e->getMessage());
        }
    }
}
?>