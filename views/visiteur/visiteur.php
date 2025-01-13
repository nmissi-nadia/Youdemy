<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Catalogue des Cours</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-100 to-white min-h-screen">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white/80 backdrop-blur-sm shadow-sm z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-2">
                    <a href="/" class="text-3xl font-bold text-indigo-600">Youdemy</a>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition">Catalogue</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition">Catégories</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition">Comment ça marche</a>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="px-4 py-2 rounded-lg text-indigo-600 hover:bg-indigo-50 transition">Connexion</button>
                    <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Inscription</button>
                </div>
            </div>
        </div>
    </nav>

    <!-- En-tête de recherche -->
    <div class="pt-24 pb-6 bg-white shadow-sm">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Explorez nos cours</h1>
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <input type="text" 
                                   placeholder="Rechercher un cours..." 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent pl-12">
                            <svg class="w-6 h-6 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <select class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-600 focus:border-transparent">
                            <option>Toutes les catégories</option>
                            <option>Développement Web</option>
                            <option>Business</option>
                            <option>Design</option>
                        </select>
                        <button class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                            Rechercher
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="border-b">
        <div class="container mx-auto px-4 py-4">
            <div class="flex flex-wrap items-center gap-4">
                <span class="text-gray-600">Filtres :</span>
                <button class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition">Gratuit</button>
                <button class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition">Débutant</button>
                <button class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition">< 5h</button>
                <button class="px-3 py-1 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition">Français</button>
            </div>
        </div>
    </div>

    <!-- Grille des cours -->
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Carte de cours -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105">
                <div class="relative pb-48 overflow-hidden">
                    <img class="absolute inset-0 h-full w-full object-cover" src="/api/placeholder/400/320" alt="thumbnail">
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-indigo-600 font-semibold">Développement Web</span>
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">Gratuit</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Introduction au HTML/CSS</h3>
                    <p class="text-gray-600 mt-2">Apprenez les bases du développement web moderne avec HTML5 et CSS3.</p>
                    <div class="mt-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <img class="h-8 w-8 rounded-full" src="/api/placeholder/32/32" alt="Instructor">
                            <span class="ml-2 text-sm text-gray-600">Par John Doe</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-yellow-500">★★★★☆</span>
                            <span class="text-sm text-gray-600 ml-1">4.5</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Répéter pour plus de cours -->
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            <nav class="flex items-center space-x-2">
                <button class="p-2 rounded-lg border text-gray-600 hover:bg-gray-100 disabled:opacity-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button class="px-4 py-2 rounded-lg bg-indigo-600 text-white">1</button>
                <button class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">2</button>
                <button class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">3</button>
                <span class="px-4 py-2">...</span>
                <button class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100">8</button>
                <button class="p-2 rounded-lg border text-gray-600 hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </nav>
        </div>
    </div>

    <script>
        // Animation d'entrée des cartes
        window.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.bg-white.rounded-xl');
            
            cards.forEach((card, index) => {
                gsap.from(card, {
                    duration: 0.6,
                    opacity: 0,
                    y: 30,
                    delay: index * 0.1,
                    ease: "power3.out"
                });
            });
        });
    </script>
</body>
</html>