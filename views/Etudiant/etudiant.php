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
$etudiant = new Etudiant($_SESSION['user_id'], $_SESSION['user_nom'], $_SESSION['user_prenom'], $_SESSION['user_email']);

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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Bienvenue, <?php echo $etudiant->getPrenom() . ' ' . $etudiant->getNom(); ?>!</h1>
        <nav>
            <a href="logout.php">Déconnexion</a>
        </nav>
    </header>

    <main>
        <section id="catalogue">
            <h2>Catalogue des cours</h2>
            <form method="get" action="">
                <input type="text" name="search" placeholder="Rechercher des cours...">
                <button type="submit">Rechercher</button>
            </form>
            <div class="cours-list">
                <?php foreach ($coursCatalogue as $cours): ?>
                    <div class="cours-item">
                        <h3><?php echo htmlspecialchars($cours['titre']); ?></h3>
                        <p><?php echo htmlspecialchars($cours['description']); ?></p>
                        <p>Enseignant : <?php echo htmlspecialchars($cours['enseignant']); ?></p>
                        <form method="post" action="">
                            <input type="hidden" name="id_cours" value="<?php echo $cours['idcours']; ?>">
                            <button type="submit" name="inscrire">S'inscrire</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="mes-cours">
            <h2>Mes cours</h2>
            <div class="cours-list">
                <?php foreach ($mesCours as $cours): ?>
                    <div class="cours-item">
                        <h3><?php echo htmlspecialchars($cours['titre']); ?></h3>
                        <p><?php echo htmlspecialchars($cours['description']); ?></p>
                        <p>Avancement : <?php echo htmlspecialchars($cours['avancement']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <?php if ($message): ?>
            <p class="message"> <?php echo htmlspecialchars($message); ?> </p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2025 Youdemy. Tous droits réservés.</p>
    </footer>
</body>
</html>
