<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Page non trouvée</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        @keyframes wave {
            0% { transform: rotate(0deg); }
            25% { transform: rotate(-10deg); }
            75% { transform: rotate(10deg); }
            100% { transform: rotate(0deg); }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        .waving {
            animation: wave 2s ease-in-out infinite;
            transform-origin: 70% 70%;
        }

        .search-animation {
            transition: all 0.3s ease;
        }

        .search-animation:focus {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gradient-to-b from-indigo-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-4xl w-full text-center">
        <!-- Logo Youdemy -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-indigo-600">Youdemy</h1>
        </div>

        <!-- Section 404 Animée -->
        <div class="relative mb-12">
            <div class="text-9xl font-bold text-indigo-600 opacity-10 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                404
            </div>
            <div class="floating relative z-10">
                <img src="/api/placeholder/300/200" alt="404 Illustration" class="mx-auto mb-8">
            </div>
        </div>

        <!-- Message d'erreur -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Oops! Page non trouvée</h2>
            <p class="text-gray-600 max-w-md mx-auto">
                Il semble que vous ayez pris un mauvais virage dans votre parcours d'apprentissage. 
                Pas d'inquiétude, ça arrive aux meilleurs d'entre nous!
            </p>
        </div>

        <!-- Barre de recherche -->
        <div class="max-w-md mx-auto mb-8">
            <div class="relative">
                <input type="text" 
                       placeholder="Rechercher un cours..." 
                       class="w-full px-6 py-3 rounded-full border-2 border-indigo-200 focus:border-indigo-600 focus:outline-none search-animation shadow-sm">
                <button class="absolute right-3 top-1/2 transform -translate-y-1/2 text-indigo-600 hover:text-indigo-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Suggestions de redirection -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 max-w-2xl mx-auto">
            <a href="#" class="p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 group">
                <div class="text-indigo-600 mb-2">
                    <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <div class="font-medium text-gray-800 group-hover:text-indigo-600 transition-colors">Page d'accueil</div>
            </a>
            <a href="#" class="p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 group">
                <div class="text-indigo-600 mb-2">
                    <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div class="font-medium text-gray-800 group-hover:text-indigo-600 transition-colors">Catalogue de cours</div>
            </a>
            <a href="#" class="p-4 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 group">
                <div class="text-indigo-600 mb-2">
                    <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="font-medium text-gray-800 group-hover:text-indigo-600 transition-colors">Support</div>
            </a>
        </div>

        <!-- Message d'encouragement -->
        <div class="text-gray-600 waving inline-block">
            👋 Besoin d'aide ? Notre équipe de support est là pour vous !
        </div>
    </div>

    <script>
        // Animation de la barre de recherche
        const searchInput = document.querySelector('input[type="text"]');
        searchInput.addEventListener('focus', () => {
            searchInput.parentElement.classList.add('scale-105');
        });
        searchInput.addEventListener('blur', () => {
            searchInput.parentElement.classList.remove('scale-105');
        });

        // Gestion de la recherche
        const searchButton = document.querySelector('button');
        searchButton.addEventListener('click', () => {
            const searchTerm = searchInput.value;
            if (searchTerm) {
                window.location.href = `/search?q=${encodeURIComponent(searchTerm)}`;
            }
        });

        // Gestion de la soumission du formulaire avec Enter
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && searchInput.value) {
                window.location.href = `/search?q=${encodeURIComponent(searchInput.value)}`;
            }
        });
    </script>
</body>
</html>