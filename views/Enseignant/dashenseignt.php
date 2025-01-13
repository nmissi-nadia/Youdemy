<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Tableau de bord Enseignant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
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
                        <span class="ml-2">Prof. Martin</span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats rapides -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                        <i class="fas fa-book text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm text-gray-500">Cours actifs</div>
                        <div class="text-2xl font-semibold">12</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm text-gray-500">Étudiants total</div>
                        <div class="text-2xl font-semibold">256</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-star text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm text-gray-500">Note moyenne</div>
                        <div class="text-2xl font-semibold">4.8/5</div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-coins text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm text-gray-500">Revenus du mois</div>
                        <div class="text-2xl font-semibold">2 450 €</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Graphique des inscriptions -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Évolution des inscriptions</h2>
                <canvas id="enrollmentChart" height="300"></canvas>
            </div>

            <!-- Dernières activités -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Activités récentes</h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="p-2 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">Nouvelle inscription</p>
                            <p class="text-xs text-gray-500">Sarah D. a rejoint "JavaScript Avancé"</p>
                            <p class="text-xs text-gray-400">Il y a 2 heures</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="p-2 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-comment"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">Nouveau commentaire</p>
                            <p class="text-xs text-gray-500">Pierre M. a commenté "Python pour débutants"</p>
                            <p class="text-xs text-gray-400">Il y a 3 heures</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="p-2 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium">Certification complétée</p>
                            <p class="text-xs text-gray-500">Marie L. a terminé "HTML/CSS Masterclass"</p>
                            <p class="text-xs text-gray-400">Il y a 5 heures</p>
                        </div>
                    </div>
                </div>
                <a href="#" class="block mt-4 text-center text-indigo-600 hover:text-indigo-800">Voir toutes les activités</a>
            </div>
        </div>

        <!-- Liste des cours -->
        <div class="mt-8 bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Mes cours</h2>
                    <button class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Note</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Progression</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded" src="/api/placeholder/40/40" alt="Course">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium">JavaScript Avancé</div>
                                        <div class="text-sm text-gray-500">Programmation Web</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm">85 étudiants</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                                    <span>4.9</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 rounded-full h-2" style="width: 75%"></div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <button class="text-indigo-600 hover:text-indigo-900">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Répétez pour d'autres cours -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Configuration du graphique d'inscriptions
        const ctx = document.getElementById('enrollmentChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
                datasets: [{
                    label: 'Nouvelles inscriptions',
                    data: [30, 45, 60, 55, 75, 85],
                    borderColor: 'rgb(99, 102, 241)',
                    tension: 0.3,
                    fill: true,
                    backgroundColor: 'rgba(99, 102, 241, 0.1)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Gestion des notifications
        document.querySelector('.fa-bell').parentElement.addEventListener('click', () => {
            // Logique pour afficher les notifications
            console.log('Affichage des notifications');
        });

        // Gestion du nouveau cours
        document.querySelector('button:contains("Nouveau cours")').addEventListener('click', () => {
            // Logique pour créer un nouveau cours
            console.log('Création d\'un nouveau cours');
        });
    </script>
</body>
</html>