<?php
session_start();
require_once '../../classes/Database.php';
require_once '../../classes/User.php';
require_once '../../classes/Enseignant.php';
require_once '../../classes/CoursVideo.php';
require_once '../../classes/CoursTexte.php';

// Vérifier si l'utilisateur est connecté et est un enseignant
if (!isset($_SESSION['user_id']) && !isset($_SESSION['role']) !== 'Enseignant') {
    header('Location: ../login.php');
    exit();
}

// Récupérer l'instance de l'enseignant
$enseignant = new Enseignant($_SESSION['user_id'], $_SESSION['user_nom'], $_SESSION['user_prenom'], $_SESSION['user_email'], $_SESSION['user_role'],'');

// Gestion des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    try {
        $action = $_POST['action'];
        $tags1  = $_POST['tags'];
        var_dump($tags1);
        switch ($action) {
            case 'ajouter':
                // Ajouter un nouveau cours
                $titre = $_POST['titre'];
                $description = $_POST['description'];
                $categorieId = intval($_POST['categorie']);
                $lienVideo = $_POST['lien_video'] ?? null;

                if ($lienVideo) {
                    $cours = new CoursVideo($titre, $description,'', $lienVideo, $categorieId, $_SESSION['user_id']);
                    $cours->ajouterCours($titre, $description,'', $lienVideo, $categorieId, $_SESSION['user_id'],$tags1);

                } else {
                    // Ajouter un cours texte
                    $cours = new CoursTexte($titre, $description, '','', $categorieId, $_SESSION['user_id']);
                    $cours->ajouterCours($titre, $description, '','', $categorieId, $_SESSION['user_id'],$tags1);
                }
                
                break;

            case 'modifier':
                // Modifier un cours existant
                $id = intval($_POST['idcours']);
                $titre = trim($_POST['titre']);
                $description = trim($_POST['description']);
                $documentation = trim($_POST['documentation']);
                $pathVedio = trim($_POST['path_vedio']);

                try {
                    $coursInstance = new Cours(); // Assurez-vous que l'objet est correctement initialisé
                    if ($coursInstance->modifierCours($id, $titre, $description, $documentation, $pathVedio)) {
                        echo "<p class='text-green-500'>Cours mis à jour avec succès.</p>";
                    } else {
                        echo "<p class='text-red-500'>Erreur lors de la mise à jour du cours.</p>";
                    }
                } catch (Exception $e) {
                    echo "<p class='text-red-500'>Une erreur s'est produite : " . htmlspecialchars($e->getMessage()) . "</p>";
                }
                break;

            default:
                throw new Exception("Action non valide !");
        }

        header('Location: dashenseignt.php?success=action_reussie');
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
// Récupération des données pour le dashboard
$statistiques = $enseignant->recupererStatistiques();
$mesCours = $enseignant->mesCours();
$categorie=$enseignant->obtenirToutesLesCategories();
$tags = $enseignant->obtenirTousLesTags();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Tableau de bord Enseignant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Barre de navigation -->
    <nav class="bg-indigo-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <div class="text-xl font-bold">Youdemy</div>
                    <div class="ml-10 space-x-4">
                        <a href="?section=tableau-de-bord" class="px-3 py-2 rounded-md text-sm font-medium bg-indigo-700">Tableau de bord</a>
                        <a href="?section=mes-cours" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">Mes cours</a>
                        <a href="?section=statistiques" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">Statistiques</a>
                    </div>
                </div>
                <div class="flex items-center">
                <a href="../logout.php" class="ml-4 relative text-blue-800 bg-white hover:bg-purple-100 rounded-lg px-4 py-2 text-sm font-semibold transition duration-300">
                    Deconnexion
                </a>
                    <div class="ml-4 flex items-center">
                        <img class="h-8 w-8 rounded-full" src="/api/placeholder/32/32" alt="Profile">
                        <span class="ml-2">Prof. <?php echo $_SESSION['user_nom']; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </nav>  


    <?php if (isset($error)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <!-- Contenu principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        

    <?php
$section = isset($_GET['section']) ? $_GET['section'] : 'tableau-de-bord';

switch ($section) {
    case 'mes-cours':
        include 'mes-cours.php';
        break;
    case 'statistiques':
        include 'statistique.php';
        break;
    case 'tableau-de-bord':
    
}
?>
    </div>

    <!-- Modal Ajout Cours -->
        <div id="modalAjoutCours" class="hidden fixed inset-0 z-50 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <form method="POST" action="" class="space-y-4">
                    <input type="hidden" name="action" value="ajouter">

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Titre</label>
                        <input type="text" name="titre" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Catégorie</label>
                        <select name="categorie" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <?php foreach ($categorie as $cat) : ?>
                                <option value="<?= htmlspecialchars($cat['idcategorie']) ?>">
                                    <?= htmlspecialchars($cat['categorie']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tags</label>
                        <div class="mt-1">
                            <?php foreach ($tags as $tag): ?>
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" 
                                        id="tag_<?php echo $tag['idtag']; ?>" 
                                        name="tags[]" 
                                        value="<?php echo $tag['idtag']; ?>" 
                                        class="form-radio h-4 w-4 text-indigo-600">
                                    <label for="tag_<?php echo $tag['idtag']; ?>" class="ml-2 text-sm text-gray-700">
                                        <?php echo htmlspecialchars($tag['tag']); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Lien Vidéo (Optionnel)</label>
                        <input type="text" name="lien_video"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" 
                                onclick="document.getElementById('modalAjoutCours').classList.add('hidden')"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                            Annuler
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Modifier Cours -->
    <!-- Modal Modifier Cours -->
        <div id="modalModifCours" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <form method="POST" action="" class="space-y-4">
                    <input type="hidden" name="action" value="modifier">
                    <input type="hidden" name="cours_id" id="modif_cours_id">

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Titre</label>
                        <input type="text" name="titre" id="modif_titre" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="modif_description" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Catégorie</label>
                        <select name="categorie" id="modif_categorie" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <?php foreach ($categorie as $cat) : ?>
                                <option value="<?= htmlspecialchars($cat['idcategorie']) ?>">
                                    <?= htmlspecialchars($cat['categorie']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tags (séparés par des virgules)</label>
                        <input type="text" name="tags" id="modif_tags"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Lien Vidéo (Optionnel)</label>
                        <input type="text" name="lien_video" id="modif_lien_video"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" 
                                onclick="document.getElementById('modalModifierCours').classList.add('hidden')"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                            Annuler
                        </button>
                        <button type="submit" name="action" value="modifierCours"
                                class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
 <?php include '../footer.html'; ?>
    <script>
        function ouvrirModalModifierCours(cours) {
            document.getElementById('idcours').value = cours.idcours;
            document.getElementById('titre').value = cours.titre;
            document.getElementById('description').value = cours.description;
            document.getElementById('documentation').value = cours.documentation || '';
            document.getElementById('path_vedio').value = cours.path_vedio || '';
            document.getElementById('modalModifierCours').classList.remove('hidden');
        }
    </script>
       
</body>
</html>