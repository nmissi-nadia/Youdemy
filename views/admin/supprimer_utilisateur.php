<?php
 session_start();
 require_once '../../classes/Database.php';
 require_once '../../classes/Admin.php';
 require_once '../../classes/User.php';

 if (!isset($_SESSION['user_id']) && !isset($_SESSION['role_id']) !== 'admin') {
     header('Location: ../home.php');
     exit;
 }

 $admin = new Admin($_SESSION['user_id'], $_SESSION['user_nom'], $_SESSION['user_prenom'], $_SESSION['user_email'], $_SESSION['user_role'],''
);


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    if ($admin->supprimerUtilisateur($id)) {
        header("Location: dashadmin.php?message=Utilisateur supprimé avec succès");
    } else {
        header("Location: dashadmin.php?error=Échec de la suppression de l'utilisateur");
    }
}
?>