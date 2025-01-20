<?php
session_start();
require_once '../../classes/Database.php';
require_once '../../classes/User.php';
require_once '../../classes/Enseignant.php';

// // Vérifier si l'utilisateur est connecté et est un enseignant
// if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Enseignant') {
//     header('Location: ../login.php');
//     exit();
// }

// Récupérer l'instance de l'enseignant
$enseignant = new Enseignant($_SESSION['user_id'], $_SESSION['user_nom'], $_SESSION['user_prenom'], $_SESSION['user_email'], $_SESSION['user_role'],'');

// Traitement des actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'ajouterCours':
                    $tags = explode(',', $_POST['tags']);
                    $enseignant->ajouterCours(
                        $_POST['titre'],
                        $_POST['description'],
                        $_POST['contenu'],
                        $tags,
                        $_POST['categorie']
                    );
                    header('Location: ' . $_SERVER['PHP_SELF'] . '?success=cours_ajoute');
                    exit;
                    break;

                case 'modifierCours':
                    $tags = explode(',', $_POST['tags']);
                    $enseignant->modifierCours(
                        $_POST['cours_id'],
                        $_POST['titre'],
                        $_POST['description'],
                        $_POST['contenu'],
                        $tags,
                        $_POST['categorie']
                    );
                    header('Location: ' . $_SERVER['PHP_SELF'] . '?success=cours_modifie');
                    exit;
                    break;

                case 'supprimerCours':
                    $enseignant->supprimerCours($_POST['cours_id']);
                    header('Location: ' . $_SERVER['PHP_SELF'] . '?success=cours_supprime');
                    exit;
                    break;
            }
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Récupération des données pour le dashboard
$statistiques = $enseignant->recupererStatistiques();
$mesCours = $enseignant->mesCours();

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
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium bg-indigo-700">Tableau de bord</a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">Mes cours</a>
                        <a href="#" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">Statistiques</a>
                    </div>
                </div>
                <div class="flex items-center">
                    <button class="ml-4 relative">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute -top-1 -right-1 bg-red-500 rounded-full w-4 h-4 text-xs flex items-center justify-center">3</span>
                    </button>
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
        <!-- Stats rapides -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <?php foreach ($statistiques as $stat): ?>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="ml-4">
                        <div class="text-sm text-gray-500"><?php echo htmlspecialchars($stat['titre']); ?></div>
                        <div class="text-2xl font-semibold"><?php echo htmlspecialchars($stat['nb_inscriptions']); ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Liste des cours -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Mes cours</h2>
                    <button onclick="document.getElementById('modalAjoutCours').classList.remove('hidden')" 
                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                        <i class="fas fa-plus mr-2"></i>Nouveau cours
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Étudiants</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mesCours as $cours): ?>
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium"><?php echo htmlspecialchars($cours['titre']); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo htmlspecialchars($cours['description']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm"><?php echo $cours['nbre_inscriptions']; ?> étudiants</div>
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST" class="inline">
                                    <input type="hidden" name="cours_id" value="<?php echo $cours['idcours']; ?>">
                                    <button type="button" 
                                            onclick="modifierCours(<?php echo htmlspecialchars(json_encode($cours)); ?>)" 
                                            class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="submit" 
                                            name="action" 
                                            value="supprimerCours" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')"
                                            class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Ajout/Modification Cours -->
    <div id="modalAjoutCours" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <form method="POST" class="space-y-4">
                <input type="hidden" name="action" value="ajouterCours">
                <input type="hidden" name="cours_id" id="cours_id">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Titre</label>
                    <input type="text" name="titre" id="titre" required 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" required 
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Catégorie</label>
                    <select name="categorie" id="categorie" required 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="web">Développement Web</option>
                        <option value="mobile">Développement Mobile</option>
                        <option value="data">Data Science</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tags (séparés par des virgules)</label>
                    <input type="text" name="tags" id="tags"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Contenu</label>
                    <textarea name="contenu" id="contenu" required 
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
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

    <script>
    function modifierCours(cours) {
        document.querySelector('input[name="action"]').value = 'modifierCours';
        document.getElementById('cours_id').value = ;
        document.getElementById('titre').value = cours.titre;
        document.getElementById('description').value = cours.description;
        document.getElementById('categorie').value = cours.categorie;
        document.getElementById('tags').value = cours.tags;
        document.getElementById('contenu').value = cours.contenu;
        
        document.getElementById('modalAjoutCours').classList.remove('hidden');
    }
    </script>
        <?php include '../footer.html'; ?>
</body>
</html>