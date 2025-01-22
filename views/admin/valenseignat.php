<?php
    session_start();
    require_once '../../classes/Database.php';
    require_once '../../classes/Admin.php';
    require_once '../../classes/Cours.php';

    if (!isset($_SESSION['user_id']) && !isset($_SESSION['role_id']) !== 'admin') {
        header('Location: ../home.php');
        exit;
    }

    $admin = new Admin($_SESSION['user_id'], $_SESSION['user_nom'], $_SESSION['user_prenom'], $_SESSION['user_email'], $_SESSION['user_role'],''
);


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Administratif</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="../../assets/img/yodemyicon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-indigo-600 text-white flex-shrink-0">
            <div class="p-4">
                <h2 class="text-2xl font-bold mb-8">Admin Dashboard</h2>
                <nav class="space-y-2">
                    <a href="dash_admin.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700">
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
                    <a href="cours.php" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-blue-700">
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
          
                 
               
<!-- Validation des comptes enseignants -->
        <div class=" pl-4 rounded-lg shadow-md mb-6 justify-center items-center">
                        <h2 class="text-xl font-bold mb-4">Validation des comptes enseignants</h2>
                        <table class="min-w-full bg-white">
                            <thead class="bg-indigo-200">
                                <tr>
                                    <th class="py-2">Nom</th>
                                    <th class="py-2">Email</th>
                                    <th class="py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                              
                              $enseignantsEnAttente = $admin->obtenirEnseignantsEnAttente();
                              foreach ($enseignantsEnAttente as $ligne) {
                                  echo "<tr>";
                                  echo "<td class='justify-self-center py-2'>{$ligne['nom']}</td>";
                                  echo "<td class='py-2'>{$ligne['email']}</td>";
                                  echo "<td class='py-2'><a href='valider_enseignant.php?id={$ligne['iduser']}' class='bg-green-500 text-white px-4 py-2 rounded'>Valider</a></td>";
                                  echo "</tr>";
                              }
                                ?>
                            </tbody>
                        </table>
                    </div>
            
    
        </div>

                

</body>
</html>