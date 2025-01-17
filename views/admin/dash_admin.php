<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Administratif</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../../assets/img/yodemyicon.png" type="image/x-icon">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-800 text-white flex-shrink-0">
            <div class="p-4">
                <h2 class="text-2xl font-bold mb-8">Admin Dashboard</h2>
                <nav class="space-y-2">
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Enseignants</span>
                    </a>
                    <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span>Cours</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="p-8">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-800">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500">Enseignants</p>
                                <p class="text-2xl font-semibold">25</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-800">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500">Cours</p>
                                <p class="text-2xl font-semibold">84</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-800">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500">Étudiants</p>
                                <p class="text-2xl font-semibold">1,520</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 text-red-800">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500">En attente</p>
                                <p class="text-2xl font-semibold">8</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-4">Distribution des Cours</h3>
                        <canvas id="coursesChart"></canvas>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-4">Top Enseignants</h3>
                        <canvas id="teachersChart"></canvas>
                    </div>
                </div>
                <!-- Validation des comptes enseignants -->
                    <div class="bg-white p-4 rounded-lg shadow-md mb-6">
                        <h2 class="text-xl font-bold mb-4">Validation des comptes enseignants</h2>
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2">Nom</th>
                                    <th class="py-2">Email</th>
                                    <th class="py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch pending teacher accounts
                                $bd = Database::getInstance();
                                $pdo = $bd->getConnection();
                                $stmt = $pdo->query("SELECT * FROM user WHERE role = 'Enseignant' AND status = 'pending'");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td class='py-2'>{$row['nom']}</td>";
                                    echo "<td class='py-2'>{$row['email']}</td>";
                                    echo "<td class='py-2'><a href='validate_teacher.php?id={$row['iduser']}' class='bg-green-500 text-white px-4 py-2 rounded'>Valider</a></td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
            </div>
                <!-- Recent Activity -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Activités Récentes</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enseignant</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200" id="activityTable">
                                <!-- Les données seront insérées ici via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialisation des graphiques
        document.addEventListener('DOMContentLoaded', function() {
            // Graphique des cours
            const coursesCtx = document.getElementById('coursesChart').getContext('2d');
            new Chart(coursesCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Sciences', 'Mathématiques', 'Langues', 'Histoire', 'Arts'],
                    datasets: [{
                        data: [30, 25, 15, 10, 20],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(255, 206, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(153, 102, 255, 0.8)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // Graphique des enseignants
            const teachersCtx = document.getElementById('teachersChart').getContext('2d');
            new Chart(teachersCtx, {
                type: 'bar',
                data: {
                    labels: ['Prof. Martin', 'Prof. Bernard', 'Prof. Durant'],
                    datasets: [{
                        label: 'Nombre d\'étudiants',
                        data: [120, 85, 75],
                        backgroundColor: 'rgba(54, 162, 235, 0.8)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
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

            // Ajout des activités récentes
            const activities = [
                { teacher: 'Prof. Martin', action: 'Nouveau cours ajouté', date: '2024-01-16', status: 'Validé' },
                { teacher: 'Prof. Bernard', action: 'Modification du cours', date: '2024-01-15', status: 'En attente' },
                { teacher: 'Prof. Durant', action: 'Inscription validée', date: '2024-01-14', status: 'Validé' }
            ];

            const activityTable = document.getElementById('activityTable');
            activities.forEach(activity => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="text-sm font-medium text-gray-900">${activity.teacher}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">${activity.action}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">${activity.date}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${
                            activity.status === 'Validé' 
                                ? 'bg-green-100 text-green-800' 
                                : 'bg-yellow-100 text-yellow-800'
                        }">
                            ${activity.status}
                        </span>
                    </td>
                `;
                activityTable.appendChild(row);
            });
        });
    </script>
</body>
</html>