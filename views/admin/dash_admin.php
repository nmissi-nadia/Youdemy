<?php
    session_start();
    require_once '../../classes/Database.php';
    require_once '../../classes/Admin.php';
    require_once '../../classes/Cours.php';
    require_once '../../classes/Tag.php';
    require_once '../../classes/Categorie.php';

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
    //ajout
    if(isset($_POST["add-categorie"])) {
        $cat = new Categorie($_POST['nom-categorie']);
        $cat->addCategory($cat->getCategorie());
    }
    //delete
    if(isset($_POST["delete-cat"])) {
        $cat = new Categorie('');
        $id= $_POST["cat-id"];
        $cat->deleteCategory($id);
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
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700">
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
                    <a href="cours.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span>Cours</span>
                    </a>
                </nav>
            </div>
        </div>
      
       
        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="p-8">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-800">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500">Enseignants</p>
                                <p class="text-2xl font-semibold"><?php echo $nombreTotalEnseignants; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-800">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500">Cours</p>
                                <p class="text-2xl font-semibold"><?php echo $nombreTotalCours; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-800">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500">Étudiants</p>
                                <p class="text-2xl font-semibold"><?php echo $nombreTotalEtudiants; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 text-red-800">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500">En attente</p>
                                <p class="text-2xl font-semibold"><?php echo $nombreEnseignantsEnAttente; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                
                    <!-- Gestion des utilisateurs -->
                    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">Gestion des utilisateurs</h2>
                            <div class="relative">
                                <input type="text" 
                                    placeholder="Rechercher un utilisateur..." 
                                    class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-indigo-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($tousLesUtilisateurs as $ligne): ?>
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900"><?php echo $ligne['nom']; ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900"><?php echo $ligne['email']; ?></div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php
                        $statusClass = match($ligne['status']) {
                            'actif' => 'bg-green-100 text-green-800',
                            'suspendu' => 'bg-yellow-100 text-yellow-800',
                            default => 'bg-gray-100 text-gray-800'
                        };
                        ?>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $statusClass; ?>">
                            <?php echo $ligne['status']; ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <button onclick="window.location.href='activer_utilisateur.php?id=<?php echo $ligne['iduser']; ?>'"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Activer
                            </button>
                            <button onclick="window.location.href='suspendre_utilisateur.php?id=<?php echo $ligne['iduser']; ?>'"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                Suspendre
                            </button>
                            <button onclick="confirmerSuppression(<?php echo $ligne['iduser']; ?>)"
                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Supprimer
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Affichage de <span class="font-medium">1</span> à <span class="font-medium">10</span> sur <span class="font-medium">20</span> utilisateurs
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Précédent</span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">1</a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-blue-50 text-sm font-medium text-blue-600 hover:bg-blue-100">2</a>
                    <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">3</a>
                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Suivant</span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</div>
                    <!-- Gestion des contenus -->
            <div class="bg-indigo-200 p-4 rounded-lg shadow-md mb-6">
                <h2 class="text-xl font-bold mb-4">Gestion des contenus</h2>
                <!-- Catégories -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">Catégories</h3>
                    <table class="min-w-full bg-white rounded-lg">
                        <thead class="bg-indigo-500 rounded-lg">
                            <tr>
                                <th class="py-2">Nom</th>
                                <th class="py-2">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch all categories
                            $toutesLesCategories = $admin->obtenirToutesLesCategories();
                            foreach ($toutesLesCategories as $categorie) {
                                echo "<tr>";
                                echo "<td class='py-2'>{$categorie['categorie']}</td>";
                                echo "<td class='py-2 flex justify-around'>
                                    <button onclick='openEditcatModal(\"{$categorie['idcategorie']}\", \"".htmlspecialchars($categorie['categorie'], ENT_QUOTES, 'UTF-8')."\")' 
                                            class='p-2 text-blue-600 hover:bg-purple-50 rounded-lg transition duration-200 hover:scale-110' 
                                            title='Modifier'>
                                        <i class='fas fa-edit'></i>
                                    </button>
                                    <form method='POST' action=''>
                                        <input name='cat-id' type='hidden' value='{$categorie['idcategorie']}'>
                                        <button name='delete-cat' class='p-2 text-red-500 hover:bg-pink-50 rounded-lg transition duration-200 hover:scale-110' title='Supprimer'>
                                            <i class='fas fa-trash'></i>
                                        </button>
                                    </form>
                                </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <section class="flex items-center justify-between gap-5 p-5">
                        <button id="open-add-categorie" type="button" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 ">Ajouter un Catégorie</button>
                    </section>
                </div>
                <!-- Tags -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-4">Tags</h3>
                    <table class="min-w-full bg-white">
                        <thead class="bg-indigo-500">
                            <tr>
                                <th class="py-2">id</th>
                                <th class="py-2">Nom</th>
                                <th class="py-2">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $tousLesTags = $admin->obtenirTousLesTags();
                            foreach ($tousLesTags as $tag) {
                                echo "<tr>";
                                echo "<td class='py-2'>{$tag['idtag']}</td>";
                                echo "<td class='py-2'>{$tag['tag']}</td>";
                                echo "<td class='py-2 flex justify-around'>
                                    <button type='button' onclick='openEditModal(\"{$tag['idtag']}\", \"{$tag['tag']}\")' 
                                            class='p-2 text-blue-600 hover:bg-purple-50 rounded-lg transition duration-200 hover:scale-110'>
                                        <i class='fas fa-edit'></i>
                                    </button>
                                    <form method='POST' action=''>
                                        <input name='tag-id' type='hidden' value='{$tag['idtag']}'>
                                        <button name='delete-tag' class='p-2 text-red-500 hover:bg-pink-50 rounded-lg transition duration-200 hover:scale-110' title='Supprimer'>
                                            <i class='fas fa-trash'></i>
                                        </button>
                                    </form>
                                </td>";
                                echo "</tr>";
                            }
                            ?>

                        </tbody>
                    </table>
                    <section class="flex items-center justify-between gap-5 p-5">
                        <button id="open-add-tag" type="button" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 ">Ajouter un Tag</button>
                        <button type="button" class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Ajouter Multiple Tags</button>
                    </section>

                      <!-- Ajout Categorie -->
                <div style="display: none;"  id="add-cat-form" class="z-10 fixed inset-0 bg-gray-900 bg-opacity-80 flex justify-center items-center ">
                    <div class="max-w-md w-full space-y-8 bg-white px-8 py-5 rounded-lg shadow-lg animate__animated animate__fadeIn">
                        <div>
                            <h2 class="text-center text-2xl font-extrabold text-gray-900">
                                Nouveau Catégorie
                            </h2>
                        </div>
                        <form method="POST" action="" id="addCategorieForm" class="mt-8 space-y-6">
                            <div class="rounded-md shadow-sm flex flex-col gap-5">
                                <div>
                                    <label for="nom-categorie" class="sr-only">Nom</label>
                                    <input id="nom-categorie" name="nom-categorie" type="text" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm" placeholder="Nom du Categorie">
                                </div>
                            </div>

                            <div class="flex items-center gap-10">
                                <button type="submit" name="add-categorie" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium  text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    Enregister
                                </button>
                                <button type="button" name="cancel-tag" id="cancel-tag" class="group relative w-full flex justify-center py-2 px-4 border border-gray-800 text-sm font-medium text-black bg-transparent duration-500 hover:bg-red-700 hover:border-none hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-transparent">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                    <!-- Ajout TAG -->
                <div style="display: none;"  id="add-tag-form" class="z-10 fixed inset-0 bg-gray-900 bg-opacity-80 flex justify-center items-center ">
                    <div class="max-w-md w-full space-y-8 bg-white px-8 py-5 rounded-lg shadow-lg animate__animated animate__fadeIn">
                        <div>
                            <h2 class="text-center text-2xl font-extrabold text-gray-900">
                                Nouveau Tag
                            </h2>
                        </div>
                        <form method="POST" action="" id="addTagForm" class="mt-8 space-y-6">
                            <div class="rounded-md shadow-sm flex flex-col gap-5">
                                <div>
                                    <label for="nom-tag" class="sr-only">Nom</label>
                                    <input id="nom-tag" name="nom-tag" type="text" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm" placeholder="Nom du Tag">
                                </div>
                            </div>

                            <div class="flex items-center gap-10">
                                <button type="submit" name="add-tag" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium  text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    Enregister
                                </button>
                                <button type="button" name="cancel-tag" id="cancel-tag" class="group relative w-full flex justify-center py-2 px-4 border border-gray-800 text-sm font-medium text-black bg-transparent duration-500 hover:bg-red-700 hover:border-none hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-transparent">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Ajout multiple TAGS -->
                <div style="display: none;" id="add-multiple-tags-form" class="z-10 fixed inset-0 bg-gray-900 bg-opacity-80 flex justify-center items-center">
                    <div class="max-w-md w-full space-y-8 bg-white px-8 py-5 rounded-lg shadow-lg animate__animated animate__fadeIn">
                        <div>
                            <h2 class="text-center text-2xl font-extrabold text-gray-900">
                                Ajouter Plusieurs Tags
                            </h2>
                            <p class="mt-2 text-center text-sm text-gray-600">
                                Séparez les tags par des virgules
                            </p>
                        </div>
                        <form method="POST" action="" id="addMultipleTagsForm" class="mt-8 space-y-6">
                            <div class="rounded-md shadow-sm flex flex-col gap-5">
                                <div>
                                    <label for="tags-list" class="sr-only">Tags</label>
                                    <textarea id="tags-list" name="tags-list" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm" placeholder="tag1, tag2, tag3, ..."></textarea>
                                </div>
                            </div>

                            <div class="flex items-center gap-10">
                                <button type="submit" name="add-multiple-tags" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    Enregistrer
                                </button>
                                <button type="button" id="cancel-multiple-tags" class="group relative w-full flex justify-center py-2 px-4 border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Modif TAG MODAL -->
                <div style="display: none;" id="edit-tag-modal" class="z-10 fixed inset-0 bg-gray-900 bg-opacity-80 flex justify-center items-center">
                    <div class="max-w-md w-full space-y-8 bg-white px-8 py-5 rounded-lg shadow-lg animate__animated animate__fadeIn">
                        <div>
                            <h2 class="text-center text-2xl font-extrabold text-gray-900">
                                Modifier le Tag
                            </h2>
                        </div>
                        <form id="editTagForm" class="mt-8 space-y-6">
                            <input type="hidden" id="edit-tag-id">
                            <div class="rounded-md shadow-sm flex flex-col gap-5">
                                <div>
                                    <label for="edit-tag-name" class="sr-only">Nom</label>
                                    <input id="edit-tag-name" name="edit-tag-name" type="text" required 
                                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm" 
                                        placeholder="Nouveau nom du tag">
                                </div>
                            </div>
                            <div class="flex items-center gap-10">
                                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    Modifier
                                </button>
                                <button type="button" onclick="closeEditModal()" class="group relative w-full flex justify-center py-2 px-4 border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Modif Categorie MODAL -->
                <div style="display: none;" id="edit-categorie-modal" class="z-10 fixed inset-0 bg-gray-900 bg-opacity-80 flex justify-center items-center">
                    <div class="max-w-md w-full space-y-8 bg-white px-8 py-5 rounded-lg shadow-lg animate__animated animate__fadeIn">
                        <div>
                            <h2 class="text-center text-2xl font-extrabold text-gray-900">
                                Modifier le Categorie
                            </h2>
                        </div>
                        <form id="editCategorieForm" class="mt-8 space-y-6">
                            <input type="hidden" id="edit-cat-id">
                            <div class="rounded-md shadow-sm flex flex-col gap-5">
                                <div>
                                    <label for="edit-categorie-name" class="sr-only">Nom</label>
                                    <input id="edit-categorie-name" name="edit-categorie-name" type="text" required 
                                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm" 
                                        placeholder="Nouveau nom du Categorie">
                                </div>
                            </div>
                            <div class="flex items-center gap-10">
                                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    Modifier
                                </button>
                                <button type="button" onclick="closeEditcatModal()" class="group relative w-full flex justify-center py-2 px-4 border border-gray-300 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>      
<script>
    function confirmerSuppression(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
        window.location.href = 'supprimer_utilisateur.php?id=' + id;
    }
}
        const cancelButtonTag = document.querySelector('#cancel-tag');
        const catFormContainer = document.querySelector('#add-cat-form');
        const opencatForm = document.querySelector('#open-add-categorie');
        const catForm = document.querySelector('#addCategorieForm');
        const TagFormContainer = document.querySelector('#add-tag-form');
        const openTagForm = document.querySelector('#open-add-tag');
        const TagForm = document.querySelector('#addTagForm');
        cancelButtonTag.addEventListener('click', function() {
            TagFormContainer.style.display = 'none';
            TagForm.reset();
            catFormContainer.style.display = 'none';
            catForm.reset();
        });
        openTagForm.addEventListener('click', function() {
            TagFormContainer.style.display = 'flex';
        });
        opencatForm.addEventListener('click', function() {
            catFormContainer.style.display = 'flex';
        });
        const openMultipleTagsBtn = document.querySelector('button.bg-gradient-to-r.from-purple-500');
        const addMultipleTagsForm = document.getElementById('add-multiple-tags-form');
        const cancelMultipleTagsBtn = document.getElementById('cancel-multiple-tags');
        openMultipleTagsBtn.addEventListener('click', () => {
            addMultipleTagsForm.style.display = 'flex';
        });
        cancelMultipleTagsBtn.addEventListener('click', () => {
            addMultipleTagsForm.style.display = 'none';
        });
        const editModal = document.getElementById('edit-tag-modal');
        const editForm = document.getElementById('editTagForm');
        const editTagId = document.getElementById('edit-tag-id');
        const editTagName = document.getElementById('edit-tag-name');
        
        function openEditModal(tagId, tagName) {if(editModal){
            editTagId.value = tagId;
            editTagName.value = tagName;
            editModal.style.display = 'flex';
        }
        }
        const editcatModal = document.getElementById('edit-categorie-modal');
        const editcatForm = document.getElementById('editCategorieForm');
        const editcatId = document.getElementById('edit-cat-id');
        const editcatName = document.getElementById('edit-categorie-name');

        function openEditcatModal(tagId, tagName) {
            editcatId.value = tagId;
            editcatName.value = tagName;
            editcatModal.style.display = 'flex';
        }

        function closeEditModal() {
            editModal.style.display = 'none';
        }
        function closeEditcatModal() {
            editcatModal.style.display = 'none';
        }

        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('id_tag', editTagId.value);
            formData.append('new_name', editTagName.value);

            fetch('../../actions/update_tag.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const tagCard = document.querySelector(`[data-tag-id="${editTagId.value}"]`);
                    const tagName = tagCard.querySelector('h3');
                    tagName.textContent = editTagName.value;
                    closeEditModal();
                } else {
                    alert('Erreur lors de la modification du tag: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur est survenue lors de la modification du tag');
            });
        });



        // const cancelButtonCategory = document.querySelector('#cancel-cat');
        // const CategoryFormContainer = document.querySelector('#add-cat-form');
        // const openCategoryForm = document.querySelector('#open-add-cat');
        // const CategoryForm = document.querySelector('#addCategoryForm');

        // cancelButtonCategory.addEventListener('click', function() {
        //     CategoryFormContainer.style.display = 'none';
        //     CategoryForm.reset();
        // });

        // openCategoryForm.addEventListener('click', function() {
        //     CategoryFormContainer.style.display = 'flex';
        // });
</script>

</body>
</html>