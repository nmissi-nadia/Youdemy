<?php
    require_once 'User.php';
    require_once 'Database.php';
  
    class Enseignant extends User {

        // methode pour inscription 
        public function __construct($id, $nom, $prenom, $email,$role ,$passwordHash) {
            parent::__construct($id, $nom, $prenom, $email,'Enseignant',$passwordHash );
        }
    
        /**
         * Ajouter un cours
         */
        public function ajouterCours($titre, $description, $contenu, $categorie, $tags = [])
        {
            $db = Database::getConnection();
            $query = "INSERT INTO cours (titre, description, contenu, categorie, enseignant_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param("ssssi", $titre, $description, $contenu, $categorie, $this->id);
            
            if ($stmt->execute()) {
                $idCours = $stmt->insert_id;
    
                // Ajouter les tags associés au cours
                foreach ($tags as $tag) {
                    $this->associerTagAuCours($idCours, $tag);
                }
    
                return true;
            } else {
                throw new Exception("Erreur lors de l'ajout du cours : " . $stmt->error);
            }
        }
    
        /**
         * Associer un tag à un cours
         */
        private function associerTagAuCours($idCours, $tag)
        {
            $db = Database::getConnection();
            $query = "INSERT INTO cours_tags (id_cours, tag) VALUES (?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param("is", $idCours, $tag);
            $stmt->execute();
        }
    
        /**
         * Modifier un cours
         */
        public function modifierCours($idCours, $titre, $description, $contenu, $categorie ,$tags = [])
        {
            $db = Database::getConnection();
            $query = "UPDATE cours SET titre = ?, description = ?, contenu = ?, categorie = ? WHERE id = ? AND enseignant_id = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("ssssii", $titre, $description, $contenu, $categorie, $idCours, $this->id);
    
            if ($stmt->execute()) {
                // Mettre à jour les tags associés
                $this->mettreAJourTagsDuCours($idCours, $tags);
                return true;
            } else {
                throw new Exception("Erreur lors de la modification du cours : " . $stmt->error);
            }
        }
    
        /**
         * Supprimer un cours
         */
        public function supprimerCours($idCours)
        {
            $db = Database::getConnection();
            $query = "DELETE FROM cours WHERE id = ? AND enseignant_id = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("ii", $idCours, $this->id);
    
            if (!$stmt->execute()) {
                throw new Exception("Erreur lors de la suppression du cours : " . $stmt->error);
            }
        }
    
        /**
         * Récupérer les statistiques des cours
         */
        public function recupererStatistiques()
{
    try {
        // Connexion à la base de données via singleton
        $db = Database::getInstance()->getConnection();

        // Requête SQL
        $query = "
            SELECT 
                c.idcours, c.titre, COUNT(ci.iduser) AS nb_inscriptions
            FROM 
                cours c
            LEFT JOIN 
                enrollments ci ON c.idcours = ci.idcours
            WHERE 
                c.idEnseignant = ?
            GROUP BY 
                c.idcours, c.titre
        ";

        $stmt = $db->prepare($query);
        $stmt->bindValue(1, $this->id, PDO::PARAM_INT);

        $stmt->execute();

        $statistiques = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $statistiques;
    } catch (PDOException $e) {
        // Gestion des erreurs
        throw new Exception("Erreur lors de la récupération des statistiques : " . $e->getMessage());
    }
}

    
        /**
         * Mettre à jour les tags d'un cours
         */
        private function mettreAJourTagsDuCours($idCours, $tags)
        {
            $db = Database::getConnection();
            // Supprimer les anciens tags
            $query = "DELETE FROM cours_tags WHERE id_cours = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("i", $idCours);
            $stmt->execute();
    
            // Ajouter les nouveaux tags
            foreach ($tags as $tag) {
                $this->associerTagAuCours($idCours, $tag);
            }
        }
    
        /**
         * Récupérer les cours d'un enseignant
         */
        public function mesCours()
            {
                try {

                    $db = Database::getInstance()->getConnection();

                    $query = "SELECT * FROM cours WHERE idEnseignant = ?";
                    $stmt = $db->prepare($query);

                    $stmt->bindValue(1, $this->id, PDO::PARAM_INT);
                    $stmt->execute();
                    $cours = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    return $cours;
                } catch (PDOException $e) {
                    throw new Exception("Erreur lors de la récupération des cours : " . $e->getMessage());
                }
            }


    }

?>