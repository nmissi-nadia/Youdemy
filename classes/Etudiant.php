<?php


    class Etudiant extends User {


        public function __construct($id, $nom, $prenom, $email) {
            parent::__construct($id, $nom, $prenom, $email);
        }
    }

    

?>