<?php
  
    class Enseignant extends User {

// methode pour inscription 
public function __construct($id, $nom, $prenom, $email) {
    parent::__construct($id, $nom, $prenom, $email);
}

    }

?>