<?php
session_start();

require_once '../classes/User.php'; // Assurez-vous que User contient une méthode signup
require_once '../classes/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nettoyage et validation des entrées utilisateur
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $motDePasse = trim($_POST['password1']);
    $confirmerMotDePasse = trim($_POST['confirmerMotDePasse']);
    $role = htmlspecialchars(trim($_POST['role']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $nom = htmlspecialchars(trim($_POST['nom']));

    if (!$email || !$motDePasse || !$confirmerMotDePasse || !$role || !$prenom || !$nom) {
        $message = "Tous les champs sont obligatoires.";
        header('Location: ./inscription.php?error=' . urlencode($message));
        exit;
    }

    if ($motDePasse !== $confirmerMotDePasse) {
        $message = "Les mots de passe ne correspondent pas.";
        header('Location: ./inscription.php?error=' . urlencode($message));
        exit;
    }

    try {
        // Création de l'utilisateur et appel à la méthode signup
        
       

        // Appel à la méthode d'inscription
        $inscriptionReussie = User::signup($nom, $prenom, $email,$role, $motDePasse);

        if ($inscriptionReussie) {
            $message = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
            header('Location: ./login.php?success=' . urlencode($message));
            exit;
        } else {
            $message = "Échec de l'inscription. Veuillez réessayer.";
            header('Location: ./inscription.php?error=' . urlencode($message));
            exit;
        }
    } catch (Exception $e) {
        $message = "Erreur : " . $e->getMessage();
        header('Location: ./inscription.php?error=' . urlencode($message));
        exit;
    }
}
?>
