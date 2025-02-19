<?php
session_start();
require_once '../classes/Database.php';
require_once '../classes/User.php';
require_once '../classes/Enseignant.php';
require_once '../classes/Admin.php';
require_once '../classes/Etudiant.php';
// Gestion de la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = htmlspecialchars($_POST['emaill']);
    $motDePasse = htmlspecialchars($_POST['passwordd']);
    
    try {
       
        $utilisateur = User::signin($email, $motDePasse);
        echo "<script>alert('test6')</script>";
        // Rediriger vers la page d'accueil ou tableau de bord
        if ($_SESSION['user_role'] == 'admin') {
            echo "<script>alert('hello admin')</script>";
            header('Location: ./admin/dash_admin.php');
        } elseif ($_SESSION['user_role'] == 'Enseignant') {
            echo "<script>alert('hello teacher')</script>";
            header('Location: ./Enseignant/dashenseignt.php');
        } elseif ($_SESSION['user_role'] == 'etudiant') {
            echo "<script>alert('hello etudiant')</script>";
            header('Location: ./Etudiant/etudiant.php');
        }
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
        echo "<script>alert('Échec de la connexion. Vérifiez vos informations d'identification.')</script>";
    }
     if (isset($error)): ?>
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-4 rounded shadow-md">
                <p class="text-red-600"><?= htmlspecialchars($error); ?></p>
                <button onclick="this.parentElement.parentElement.style.display='none';" 
                        class="mt-2 px-4 py-2 bg-red-600 text-white rounded">Fermer</button>
            </div>
        </div>
        <?php endif;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Connexion/Inscription</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="/path/to/favicon.ico" type="image/x-icon">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
    <style>
        .slide-enter {
            transform: translateX(100%);
            opacity: 0;
        }
        .slide-enter-active {
            transform: translateX(0);
            opacity: 1;
            transition: all 0.5s ease-out;
        }
        .form-container {
            background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Logo et Titre -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-indigo-600 mb-2">Youdemy</h1>
                <p class="text-gray-600">Votre plateforme d'apprentissage en ligne</p>
            </div>

            <!-- Container principal -->
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    <!-- Section gauche: Image/Info -->
                    <div class="form-container w-full md:w-1/2 p-8 text-white">
                        <div class="h-full flex flex-col justify-center">
                            <h2 class="text-3xl font-bold mb-4">Bienvenue sur Youdemy</h2>
                            <p class="mb-6">Rejoignez notre communauté d'apprenants et d'enseignants passionnés.</p>
                            <ul class="space-y-4">
                                <li class="flex items-center">
                                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                                    </svg>
                                    Cours de qualité
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                                    </svg>
                                    Apprentissage personnalisé
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path>
                                    </svg>
                                    Certification reconnue
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Section droite: Formulaires -->
                    <div class="w-full md:w-1/2 p-8">
                        <div class="tabs flex justify-center mb-8">
                            <button data-tab="login" class="px-6 py-2 font-semibold text-indigo-600 border-b-2 border-indigo-600 tab-active" >Connexion</button>
                            <button  data-tab="register" class="px-6 py-2 font-semibold text-gray-500 border-b-2 border-transparent">Inscription</button>
                        </div>

                        <!-- Formulaire de connexion -->
                        <form method="POST" action="" id="loginForm" class="space-y-6">
                            <div>
                                <label class="block text-gray-700 mb-2">Email</label>
                                <input type="email" name="emaill" class="w-full px-4 py-2 rounded-lg border focus:outline-none focus:border-indigo-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2">Mot de passe</label>
                                <input type="password" name="passwordd" class="w-full px-4 py-2 rounded-lg border focus:outline-none focus:border-indigo-500" required>
                            </div>
                            <div class="flex items-center justify-between">
                                <label class="flex items-center">
                                    <input type="checkbox" class="form-checkbox text-indigo-600">
                                    <span class="ml-2 text-gray-600">Se souvenir de moi</span>
                                </label>
                                <a href="#" class="text-indigo-600 hover:text-indigo-800">Mot de passe oublié?</a>
                            </div>
                            <button type="submit" class="w-full py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                Se connecter
                            </button>
                        </form>

                        <!-- Formulaire d'inscription -->
                        <form method="POST" action="./inscription.php" id="registerForm" class="space-y-6 hidden">
                            <div>
                                <label class="block text-gray-700 mb-2">Nom complet</label>
                                <input type="text" name="nom" class="w-full px-4 py-2 rounded-lg border focus:outline-none focus:border-indigo-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2">Prénom complet</label>
                                <input type="text" name="prenom" class="w-full px-4 py-2 rounded-lg border focus:outline-none focus:border-indigo-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" class="w-full px-4 py-2 rounded-lg border focus:outline-none focus:border-indigo-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2">Rôle</label>
                                <select name="role" class="w-full px-4 py-2 rounded-lg border focus:outline-none focus:border-indigo-500" required>
                                    <option value="etudiant">Étudiant</option>
                                    <option value="Enseignant">Enseignant</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2">Mot de passe</label>
                                <input type="password" name="password1"  class="w-full px-4 py-2 rounded-lg border focus:outline-none focus:border-indigo-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 mb-2">Confirmer le mot de passe</label>
                                <input type="password" name="confirmerMotDePasse" class="w-full px-4 py-2 rounded-lg border focus:outline-none focus:border-indigo-500" required>
                            </div>
                            <button type="submit" name="inscription"  class="w-full py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                S'inscrire
                            </button>
                            <?php if (isset($message)): ?>
                    <p class="text-red-500 mt-4"><?php echo $message; ?></p>
                <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Gestion des onglets
        const tabs = document.querySelectorAll('[data-tab]');
        const forms = {
            login: document.getElementById('loginForm'),
            register: document.getElementById('registerForm')
        };

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Mise à jour des onglets
                tabs.forEach(t => {
                    t.classList.remove('text-indigo-600', 'border-indigo-600');
                    t.classList.add('text-gray-500', 'border-transparent');
                });
                tab.classList.add('text-indigo-600', 'border-indigo-600');
                tab.classList.remove('text-gray-500', 'border-transparent');

                // Affichage du formulaire correspondant
                const formToShow = tab.dataset.tab;
                Object.keys(forms).forEach(key => {
                    if (key === formToShow) {
                        forms[key].classList.remove('hidden');
                        forms[key].classList.add('slide-enter');
                        setTimeout(() => {
                            forms[key].classList.add('slide-enter-active');
                        }, 10);
                    } else {
                        forms[key].classList.add('hidden');
                        forms[key].classList.remove('slide-enter', 'slide-enter-active');
                    }
                });
            });
        });

      
    </script>
</body>
</html>