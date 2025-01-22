<?php
require_once '../classes/Cours.php';

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1; 
$parPage = 6; 
$offset = ($page - 1) * $parPage;

$cours = new Cours();
$catalogue = $cours->getPaginatedCourses($offset, $parPage);
$totalCours = $cours->countTotalCourses();
$totalPages = ceil($totalCours / $parPage); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Plateforme d'apprentissage en ligne</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../assets/img/yodemyicon.png" type="image/x-icon">
    <style>
    .gradient-border {
        position: relative;
        border-radius: 0.5rem;
        z-index: 0;
    }

    .gradient-border::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(45deg, #4f46e5, #818cf8);
        border-radius: 0.6rem;
        z-index: -1;
    }

    .category-icon {
        transition: transform 0.3s ease;
    }

    .category-item:hover .category-icon {
        transform: translateY(-5px);
    }
</style>
</head>
<body class="bg-gradient-to-br from-indigo-100 to-white min-h-screen">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white/80 backdrop-blur-sm shadow-sm z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-2">
                    <div class="text-3xl font-bold text-indigo-600">Youdemy</div>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition">Catalogue</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition">Comment ça marche</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition">Enseignants</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="./login.php" class="px-4 py-2 rounded-lg text-indigo-600 hover:bg-indigo-50 transition">Connexion</a>
                    <a href="./login.php" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Inscription</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="md:w-1/2 space-y-6">
                    <h1 class="text-4xl md:text-6xl font-bold text-gray-900 opacity-0" id="mainTitle">
                        Apprenez sans limites avec <span class="text-indigo-600">Youdemy</span>
                    </h1>
                    <p class="text-xl text-gray-600 opacity-0" id="mainDesc">
                        Découvrez des milliers de cours en ligne dispensés par des experts. Apprenez à votre rythme, où que vous soyez.
                    </p>
                    <div class="flex space-x-4 opacity-0" id="mainCta">
                        <button class="px-8 py-4 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition transform hover:scale-105">
                            Commencer maintenant
                        </button>
                        <button class="px-8 py-4 border-2 border-indigo-600 text-indigo-600 rounded-xl hover:bg-indigo-50 transition transform hover:scale-105">
                            Voir les cours
                        </button>
                    </div>
                </div>
                <div class="md:w-1/2 mt-12 md:mt-0">
                    <div class="relative">
                        <div class="absolute -inset-1 bg-indigo-600 rounded-2xl blur opacity-30"></div>
                        <div class="relative bg-white p-6 rounded-2xl shadow-xl opacity-0" id="statsCard">
                            <div class="grid grid-cols-2 gap-8">
                                <div class="text-center">
                                    <div class="text-4xl font-bold text-indigo-600 counter" data-target="1000">0</div>
                                    <div class="text-gray-600">Cours disponibles</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-4xl font-bold text-indigo-600 counter" data-target="50000">0</div>
                                    <div class="text-gray-600">Étudiants actifs</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-4xl font-bold text-indigo-600 counter" data-target="200">0</div>
                                    <div class="text-gray-600">Instructeurs</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-4xl font-bold text-indigo-600 counter" data-target="95">0</div>
                                    <div class="text-gray-600">Satisfaction %</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Catégories populaires</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="category-card">
                    <div class="bg-gradient-to-br from-purple-500 to-indigo-600 p-6 rounded-xl text-white transform transition hover:scale-105 cursor-pointer">
                        <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="text-xl font-bold mb-2">Développement Web</h3>
                        <p>Apprenez HTML, CSS, JavaScript et plus encore</p>
                    </div>
                </div>
                <div class="category-card">
                    <div class="bg-gradient-to-br from-blue-500 to-cyan-600 p-6 rounded-xl text-white transform transition hover:scale-105 cursor-pointer">
                        <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <h3 class="text-xl font-bold mb-2">Business</h3>
                        <p>Marketing, Finance et Entrepreneuriat</p>
                    </div>
                </div>
                <div class="category-card">
                    <div class="bg-gradient-to-br from-pink-500 to-rose-600 p-6 rounded-xl text-white transform transition hover:scale-105 cursor-pointer">
                        <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-xl font-bold mb-2">Design</h3>
                        <p>UI/UX, Graphisme et Animation</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-white py-8">
        <div class="container mx-auto">
            <form action="search.php" method="GET" class="flex items-center">
                <input type="text" name="search" placeholder="Rechercher un cours" class="rounded-lg border-2 border-gray-300 w-full px-4 py-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">Rechercher</button>
            </form>
        </div>
    </section>

    <div class="container mx-auto py-8">
            <h1 class="text-3xl font-bold text-center mb-6">Catalogue des Cours</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($catalogue as $cours): ?>
                    <div class="bg-white shadow-md rounded-md p-4">
                        <h2 class="text-lg font-bold"><?= htmlspecialchars($cours['titre']); ?></h2>
                        <p class="text-sm text-gray-600"><?= htmlspecialchars($cours['description']); ?></p>
                        <p class="text-sm font-medium mt-2">
                            Catégorie : <?= htmlspecialchars($cours['categorie']); ?>
                        </p>
                        <button onclick="handleInscriptionPopup()" 
                                class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                            S'inscrire
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex justify-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?= $i; ?>" 
                    class="px-4 py-2 <?= $i == $page ? 'bg-indigo-600 text-white' : 'bg-gray-300 text-gray-700' ?> rounded mx-1">
                        <?= $i; ?>
                    </a>
                <?php endfor; ?>
            </div>
    </div>
        <!-- Popup d'inscription -->
        <div id="popupInscription" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-md shadow-md w-96">
                <h2 class="text-lg font-bold mb-4">Connexion ou Inscription requise</h2>
                <p class="mb-4">Vous devez être connecté pour vous inscrire à ce cours.</p>
                <div class="flex justify-end space-x-3">
                    <a href="login.php" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Se connecter</a>
                    <a href="signup.php" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">S'inscrire</a>
                </div>
                <button onclick="closePopup()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>
            </div>
        </div>
    <!-- Section Devenir formateur -->
    <div class="bg-indigo-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex-1">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Devenez formateur sur Youdemy</h3>
                    <p class="text-gray-600 mb-6">Partagez vos connaissances avec une communauté mondiale d'apprenants passionnés.</p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-check-circle text-indigo-600 mr-2"></i>
                            Atteignez des millions d'étudiants
                        </li>
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-check-circle text-indigo-600 mr-2"></i>
                            Gagnez un revenu passif
                        </li>
                        <li class="flex items-center text-gray-600">
                            <i class="fas fa-check-circle text-indigo-600 mr-2"></i>
                            Bénéficiez de notre support technique
                        </li>
                    </ul>
                </div>
                <div class="flex-1 text-center">
                    <a href="#" class="inline-block px-8 py-4 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-semibold">
                        Commencer à enseigner
                    </a>
                </div>
            </div>
        </div>
    </div>
<!-- include fichier contenant section footer -->
    <!-- Footer Section -->
    <?php include 'footer.html'; ?>

    <script>
        
            function handleInscriptionPopup() {
                document.getElementById('popupInscription').classList.remove('hidden');
            }
            function closePopup() {
                document.getElementById('popupInscription').classList.add('hidden');
            }

        // Animation d'entrée avec GSAP
        window.addEventListener('DOMContentLoaded', () => {
            gsap.to("#mainTitle", {
                opacity: 1,
                y: 0,
                duration: 1,
                ease: "power3.out"
            });

            gsap.to("#mainDesc", {
                opacity: 1,
                y: 0,
                duration: 1,
                delay: 0.3,
                ease: "power3.out"
            });

            gsap.to("#mainCta", {
                opacity: 1,
                y: 0,
                duration: 1,
                delay: 0.6,
                ease: "power3.out"
            });

            gsap.to("#statsCard", {
                opacity: 1,
                y: 0,
                duration: 1,
                delay: 0.9,
                ease: "power3.out",
                onComplete: startCounters
            });
        });
        // Animation des catégories au survol
        document.querySelectorAll('.category-item').forEach(item => {
                item.addEventListener('mouseenter', () => {
                    const icon = item.querySelector('.category-icon');
                    icon.style.transform = 'translateY(-5px)';
                });

                item.addEventListener('mouseleave', () => {
                    const icon = item.querySelector('.category-icon');
                    icon.style.transform = 'translateY(0)';
                });
            });
        // Animation des compteurs
        function startCounters() {
            const counters = document.querySelectorAll('.counter');
            const speed = 200;

            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                const increment = target / speed;

                const updateCount = () => {
                    const count = +counter.innerText;
                    if (count < target) {
                        counter.innerText = Math.ceil(count + increment);
                        setTimeout(updateCount, 1);
                    } else {
                        counter.innerText = target;
                    }
                };

                updateCount();
            });
        }

        // Animation au scroll pour les cartes de catégories
        const categoryCards = document.querySelectorAll('.category-card');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        categoryCards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.6s ease-out';
            observer.observe(card);
        });
    </script>
</body>
</html>