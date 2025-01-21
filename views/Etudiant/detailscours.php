<?php
require_once '../../classes/Database.php';
require_once '../../classes/Etudiant.php';



// Utilisation
$courseId = $_GET['id'] ?? null;
if (!$courseId) {
    header('Location: index.php');
    exit;
}

$courseDetails = new CourseDetails();
$course = $courseDetails->getCourseDetails($courseId);
$tags = $courseDetails->getCourseTags($courseId);
?>

<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course['titre']); ?> - Détails du cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full" x-data="courseDetails()">
    <main class="min-h-screen bg-gray-50">
        <!-- Hero section avec les informations principales -->
        <div class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between">
                    <div class="mb-6 md:mb-0">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">
                            <?php echo htmlspecialchars($course['titre']); ?>
                        </h1>
                        <p class="text-lg text-gray-600 mb-4">
                            <?php echo htmlspecialchars($course['description']); ?>
                        </p>
                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                                <span class="ml-2 text-sm text-gray-600">
                                    <?php echo htmlspecialchars($course['prenom'] . ' ' . $course['nom']); ?>
                                </span>
                            </div>
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                                </svg>
                                <span class="ml-2 text-sm text-gray-600">
                                    <?php echo htmlspecialchars($course['total_inscriptions']); ?> inscrits
                                </span>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($tags as $tag): ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <?php echo htmlspecialchars($tag); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="flex flex-col items-center md:items-end">
                        <div class="bg-gray-100 rounded-lg p-6 text-center w-full md:w-auto">
                            <p class="text-sm text-gray-600 mb-2">Catégorie</p>
                            <p class="text-lg font-semibold text-gray-900">
                                <?php echo htmlspecialchars($course['categorie']); ?>
                            </p>
                        </div>
                        <button 
                            @click="toggleEnrollment"
                            class="mt-4 w-full md:w-auto inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            x-text="enrolled ? 'Déjà inscrit' : 'S\'inscrire au cours'">
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenu du cours -->
        <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <div x-show="hasVideo" class="mb-8">
                    <h2 class="text-xl font-semibold mb-4">Vidéo du cours</h2>
                    <?php if ($course['path_vedio']): ?>
                        <div class="aspect-w-16 aspect-h-9">
                            <video 
                                class="w-full rounded-lg shadow"
                                controls
                                src="<?php echo htmlspecialchars($course['path_vedio']); ?>">
                            </video>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="prose max-w-none">
                    <h2 class="text-xl font-semibold mb-4">Documentation</h2>
                    <div class="bg-gray-50 rounded-lg p-6">
                        <?php echo nl2br(htmlspecialchars($course['documentation'])); ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
    function courseDetails() {
        return {
            enrolled: false,
            hasVideo: <?php echo !empty($course['path_vedio']) ? 'true' : 'false' ?>,
            toggleEnrollment() {
                if (!this.enrolled) {
                    // Appel AJAX pour l'inscription
                    fetch('enroll_course.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            courseId: <?php echo $courseId; ?>
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            this.enrolled = true;
                            // Mettre à jour le nombre d'inscrits
                            window.location.reload();
                        }
                    });
                }
            }
        }
    }
    </script>
</body>
</html>