<?php
session_start();

require_once '../classes/User.php';
require_once '../classes/Enseignant.php';
require_once '../classes/Etudiant.php';
require_once '../classes/Database.php';

// Gestion de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $motDePasse = htmlspecialchars($_POST['password1']);
    $role = htmlspecialchars($_POST['role']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $nom = htmlspecialchars($_POST['nom']);
    $confirmerMotDePasse = htmlspecialchars($_POST['confirmerMotDePasse']);

    if ($motDePasse !== $confirmerMotDePasse) {
        $message = "Les mots de passe ne correspondent pas.";
        header('Location: ./inscription.php?error=' . urlencode($message));
        exit;
    } else {
        $user = null;
        if ($role == 'Enseignant') {
            $user = new Enseignant(null, $nom, $prenom, $email);
            if ($role == 'Enseignant') {
            } elseif ($role == 'etudiant') {
                $user = new Etudiant(null, $nom, $prenom, $email);
            } else {
                $message = "Rôle invalide.";
                header('Location: ./inscription.php?error=' . urlencode($message));
                exit;
            }
    
            if ($user) {
                $user->setPasswordHash($motDePasse);
                $user->setRole($role);
                $user->setStatus('active'); // or any default status
    
                $inscriptionReussie = $user->save();
    
                if ($inscriptionReussie) {
                    $message = "Inscription réussie! Vous pouvez maintenant vous connecter.";
                    header('Location: ./login.php?success=' . urlencode($message));
                    exit;
                } else {
                    $message = "Échec de l'inscription. Veuillez réessayer.";
                    header('Location: ./inscription.php?error=' . urlencode($message));
                    exit;
                }
            }
        }
    }
}
?>