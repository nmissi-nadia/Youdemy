<?php


    class Admin extends User {

        public function validateAccount() {
            $bd = Database::getInstance();
            $pdo = $bd->getConnection();
        
            $stmt = $pdo->prepare("UPDATE user SET status = 'active' WHERE iduser = ?");
            return $stmt->execute([$this->id]);
        }
    }

    

?>