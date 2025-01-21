<?php

// Inclusion des fichiers nécessaires
require_once '../../classes/Database.php';
require_once '../../classes/Etudiant.php';
session_start();

// Vérification de la connexion
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'etudiant') {
    header('Location: ../login.php');
    exit();
}

// Création de l'objet étudiant
$etudiant = new Etudiant($_SESSION['user_id'], $_SESSION['user_nom'], $_SESSION['user_prenom'], $_SESSION['user_email'], $_SESSION['user_role'],'');

// Gestion des actions de l'étudiant
$coursCatalogue = [];
$mesCours = [];
$message = '';

try {
    // Récupération du catalogue des cours
    $coursCatalogue = $etudiant->afficherCatalogueDesCours();

    // Récupération des cours rejoints
    $mesCours = $etudiant->mesCours();

    // Inscription à un cours
    if (isset($_POST['inscrire']) && isset($_POST['id_cours'])) {
        $idCours = (int)$_POST['id_cours'];
        $etudiant->inscrireCours($idCours);
        $message = "Inscription réussie au cours $idCours.";
        // Mise à jour des cours rejoints après inscription
        $mesCours = $etudiant->mesCours();
    }

    // Recherche de cours par mots-clés
    if (isset($_GET['search'])) {
        $keyword = htmlspecialchars($_GET['search']);
        $coursCatalogue = $etudiant->rechercherCours($keyword);
    }
} catch (Exception $e) {
    $message = $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Étudiant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body class="h-full">
    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900">
                Bienvenue, <?php echo $etudiant->getPrenom() . ' ' . $etudiant->getNom(); ?>!
            </h1>
            <nav>
                <a href="logout.php" class="inline-flex justify-center rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus:outline-none">
                    Déconnexion
                </a>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <section id="catalogue" class="mb-12">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Catalogue des cours</h2>
            <form method="get" action="" class="mb-8">
                <div class="flex gap-4">
                    <input type="text" name="search" placeholder="Rechercher des cours..." 
                           class="block w-full rounded-md border-0 py-2 px-4 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                    <button type="submit" class="inline-flex justify-center rounded-md bg-indigo-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none">
                        Rechercher
                    </button>
                </div>
            </form>
            <div class="cours-list grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($coursCatalogue as $cours): ?>
                    <a href="./detailscours.php?id=<?= $cours['idcours'] ?>">
                    <div class="cours-item bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo htmlspecialchars($cours['titre']); ?></h3>
                        <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($cours['description']); ?></p>
                        <p class="text-sm text-gray-500 mb-4">Enseignant : <?php echo htmlspecialchars($cours['enseignant']); ?></p>
                        <form method="post" action="">
                            <input type="hidden" name="id_cours" value="<?php echo $cours['idcours']; ?>">
                            <button type="submit" name="inscrire" class="w-full rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus:outline-none">
                                S'inscrire
                            </button>
                        </form>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="mes-cours" class="mb-12">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Mes cours</h2>
            <a href="./detailscours.php">
            <div class="cours-list grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($mesCours as $cours): ?>
                    <div class="cours-item bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo htmlspecialchars($cours['titre']); ?></h3>
                        <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($cours['description']); ?></p>
                        <div class="mt-4">
                            <p class="text-sm text-gray-500 mb-1">Avancement</p>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-indigo-600 h-2 rounded-full" ></div>
                            </div>
                            <p class="text-sm text-gray-500 mt-1"><?php echo htmlspecialchars($cours['dateCreation']); ?>%</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div></a>
        </section>

        <?php if ($message): ?>
            <div class="rounded-md bg-green-50 p-4 mb-8">
                <p class="text-green-700"><?php echo htmlspecialchars($message); ?></p>
            </div>
        <?php endif; ?>
    </main>

    <?php include "../footer.html"; ?>
</body>
</html>
