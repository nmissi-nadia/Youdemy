<?php


    class Admin extends User {

        public function validateAccount() {
            $bd = Database::getInstance();
            $pdo = $bd->getConnection();
        
            $stmt = $pdo->prepare("UPDATE user SET status = 'active' WHERE iduser = ?");
            return $stmt->execute([$this->id]);
        }
        public function activate() {
            $bd = Database::getInstance();
            $pdo = $bd->getConnection();
        
            $stmt = $pdo->prepare("UPDATE user SET status = 'active' WHERE iduser = ?");
            return $stmt->execute([$this->id]);
        }
        
        public function suspend() {
            $bd = Database::getInstance();
            $pdo = $bd->getConnection();
        
            $stmt = $pdo->prepare("UPDATE user SET status = 'suspended' WHERE iduser = ?");
            return $stmt->execute([$this->id]);
        }
        
        public function delete() {
            $bd = Database::getInstance();
            $pdo = $bd->getConnection();
        
            $stmt = $pdo->prepare("DELETE FROM user WHERE iduser = ?");
            return $stmt->execute([$this->id]);
        }
    }

    

?>