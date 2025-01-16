<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Plateforme d'apprentissage en ligne</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
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
    <!-- Bannière de catégories populaires -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-2xl font-bold text-center text-gray-800 mb-8">Catégories populaires</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                <a href="#" class="category-item flex flex-col items-center p-4 rounded-lg hover:bg-white hover:shadow-lg transition-all">
                    <div class="text-indigo-600 mb-3 category-icon">
                        <i class="fas fa-laptop-code text-3xl"></i>
                    </div>
                    <span class="text-gray-700 text-sm font-medium">Développement</span>
                </a>
                <a href="#" class="category-item flex flex-col items-center p-4 rounded-lg hover:bg-white hover:shadow-lg transition-all">
                    <div class="text-indigo-600 mb-3 category-icon">
                        <i class="fas fa-chart-line text-3xl"></i>
                    </div>
                    <span class="text-gray-700 text-sm font-medium">Business</span>
                </a>
                <a href="#" class="category-item flex flex-col items-center p-4 rounded-lg hover:bg-white hover:shadow-lg transition-all">
                    <div class="text-indigo-600 mb-3 category-icon">
                        <i class="fas fa-palette text-3xl"></i>
                    </div>
                    <span class="text-gray-700 text-sm font-medium">Design</span>
                </a>
                <a href="#" class="category-item flex flex-col items-center p-4 rounded-lg hover:bg-white hover:shadow-lg transition-all">
                    <div class="text-indigo-600 mb-3 category-icon">
                        <i class="fas fa-language text-3xl"></i>
                    </div>
                    <span class="text-gray-700 text-sm font-medium">Langues</span>
                </a>
                <a href="#" class="category-item flex flex-col items-center p-4 rounded-lg hover:bg-white hover:shadow-lg transition-all">
                    <div class="text-indigo-600 mb-3 category-icon">
                        <i class="fas fa-camera text-3xl"></i>
                    </div>
                    <span class="text-gray-700 text-sm font-medium">Photographie</span>
                </a>
                <a href="#" class="category-item flex flex-col items-center p-4 rounded-lg hover:bg-white hover:shadow-lg transition-all">
                    <div class="text-indigo-600 mb-3 category-icon">
                        <i class="fas fa-music text-3xl"></i>
                    </div>
                    <span class="text-gray-700 text-sm font-medium">Musique</span>
                </a>
            </div>
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