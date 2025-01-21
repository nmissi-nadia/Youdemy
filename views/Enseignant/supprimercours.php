<?php
require_once '../../classes/Cours.php'; 

$courseId = $_GET['id'] ?? null;
if (!$courseId) {
    header('Location: ./dashenseignt.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprcours'])) {
    if (!empty($courseId)) {
        $coursInstance = new Cours();
        try {
            $resultat = $coursInstance->supprimerCours($courseId);
            if ($resultat) {
                echo "<script>alert('Cours supprimé avec succès.');</script>";
                header('Location: ./dashenseignt.php');
            } else {
                echo "<script>alert('Échec de la suppression du cours.');</script>";
            }
        } catch (Exception $e) {
            echo "<script>alert('Erreur : " . addslashes($e->getMessage()) . "');</script>";
        }
    } else {
        echo "<script>alert('ID du cours manquant.');</script>";
    }
}
?>
