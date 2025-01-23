<?php
    session_start();
    require_once '../../classes/Database.php';
    require_once '../../classes/Admin.php';
    require_once '../../classes/Cours.php';

    if (!isset($_SESSION['user_id']) && !isset($_SESSION['role_id']) !== 'admin') {
        header('Location: ../home.php');
        exit;
    }

    $admin = new Admin($_SESSION['user_id'], $_SESSION['user_nom'], $_SESSION['user_prenom'], $_SESSION['user_email'], $_SESSION['user_role'],''
);



$coursInstance = new Cours();
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$coursParPage = 6;
$offset = ($page - 1) * $coursParPage;

// Gestion de la suppression
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'deletecours' && isset($_POST['cours_id'])) {
    try {
        $coursInstance->supprimerCours($_POST['cours_id']);
        $message = "Cours supprimé avec succès.";
        $messageType = "success";
    } catch (Exception $e) {
        $message = "Erreur lors de la suppression : " . $e->getMessage();
        $messageType = "error";
    }
}

try {
    $tousLesCours = $coursInstance->obtenirTousLesCours();
    $totalCours = count($tousLesCours);
    $totalPages = ceil($totalCours / $coursParPage);
    $coursPagines = array_slice($tousLesCours, $offset, $coursParPage);
} catch (Exception $e) {
    $message = $e->getMessage();
    $messageType = "error";
}


// Récupérer les statistiques
$nombreTotalEnseignants = $admin->obtenirNombreTotalEnseignants();
$nombreTotalCours = $admin->obtenirNombreTotalCours();
$nombreTotalEtudiants = $admin->obtenirNombreTotalEtudiants();
$nombreEnseignantsEnAttente = $admin->obtenirNombreEnseignantsEnAttente();
$coursAvecPlusEtudiants = $admin->obtenirCoursAvecPlusEtudiants();
$top3Enseignants = $admin->obtenirTop3Enseignants();
$tousLesUtilisateurs = $admin->obtenirTousLesUtilisateurs();
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    //ajout
    if(isset($_POST["add-tag"])) {
        $tag = new Tag($_POST['nom-tag']);
        $tag->ajoutTag($tag->getNom());
    }
    //ajout multiple de tags 
    if(isset($_POST["add-multiple-tags"])) {
        $tags_string = $_POST['tags-list'];
        $tags_array = explode(',', $tags_string);
        $tag = new Tag('');
        foreach($tags_array as $tag_name) {
            $tag_name = trim($tag_name);
            if(!empty($tag_name)) {
                $tag->ajoutTag($tag_name);
            }
        }
    }
    //delete
    if(isset($_POST["delete-tag"])) {
        $tag = new Tag('');
        $id= $_POST["tag-id"];
        $tag->supprimeTag($id);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Administratif</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../../assets/img/yodemyicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-indigo-600 text-white flex-shrink-0">
            <div class="p-4">
                <h2 class="text-2xl font-bold mb-8">Admin Dashboard</h2>
                <nav class="space-y-2">
                    <a href="dash_admin.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="valenseignat.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Enseignants</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span>Cours</span>
                    </a>
                    <a href="../logout.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Déconnexion</span>
                    </a>
                </nav>
            </div>
        </div>
        <!-- Main Content -->
        <div class=" flex-1 overflow-auto">
                    <div class="container mx-auto px-4 py-8">
                    <h1 class="text-3xl font-bold text-gray-800 mb-8">Catalogue des Cours</h1>

                    <?php if (isset($message)): ?>
                        <div class="<?php echo $messageType === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700'; ?> px-4 py-3 rounded mb-4">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($tousLesCours as $cours): ?>
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <div class="p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <h2 class="text-xl font-semibold text-gray-800">
                                            <?php echo htmlspecialchars($cours['titre']); ?>
                                        </h2>
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                            <?php echo htmlspecialchars($cours['nom_categorie']); ?>
                                        </span>
                                    </div>
                                    
                                    <p class="text-gray-600 mb-4 line-clamp-3">
                                        <?php echo htmlspecialchars($cours['description']); ?>
                                    </p>
                                    
                                    <div class="flex items-center text-sm text-gray-500 mb-4">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <?php echo htmlspecialchars($cours['enseignant']); ?>
                                    </div>
                                    
                                    <div class="flex items-center justify-between pt-4 border-t">
                                        <span class="text-sm text-gray-500">
                                            <?php echo date('d/m/Y', strtotime($cours['dateCreation'])); ?>
                                        </span>
                                        <div class="space-x-2">
                                            
                                            <!-- Formulaire de suppression -->
                                            <form action="" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?');">
                                                <input type="hidden" name="action" value="deletecours">
                                                <input type="hidden" name="cours_id" value="<?php echo $cours['idcours']; ?>">
                                                <button type="submit" name="deletecour"
                                                        class="px-3 py-1 bg-red-600 text-white text-sm font-medium rounded hover:bg-red-700">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    
                </div>
 
        </div>
            


                

</body>
</html>