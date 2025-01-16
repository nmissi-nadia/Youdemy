<?php
session_start();

require_once '../classes/User.php';
require_once '../classes/Enseignant.php';
require_once '../classes/Etudiant.php';
require_once '../classes/Database.php';

// Gestion de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $motDePasse = htmlspecialchars($_POST['motDePasse']);
    $role = htmlspecialchars($_POST['role']);

    if (isset($_POST['inscription'])) {
        $prenom = htmlspecialchars($_POST['prenom']);
        $confirmerMotDePasse = htmlspecialchars($_POST['confirmerMotDePasse']);

        if ($motDePasse !== $confirmerMotDePasse) {
            $message = "Les mots de passe ne correspondent pas.";
        } else {
            if ($role == 'Enseignant') {
                $inscriptionReussie = Enseignant::inscription($prenom, $email, $motDePasse);
            } elseif ($role == 'etudiant') {
                $inscriptionReussie = Etudiant::inscription($prenom, $email, $motDePasse);
            }

            if ($inscriptionReussie) {
                $message = "Inscription réussie! Vous pouvez maintenant vous connecter.";
                header('Location: ./login.php');
            } else {
                $message = "Échec de l'inscription. Veuillez réessayer.";
                header('Location: ./login.php');
            }
        }
    } 
    }

?>