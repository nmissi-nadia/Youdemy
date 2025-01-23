<!-- Liste des cours -->
<div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-semibold">Mes cours</h2>
                    <button onclick="document.getElementById('modalAjoutCours').classList.remove('hidden')" 
                            class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mesCours as $cours): ?>
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium"><?php echo htmlspecialchars($cours['titre']); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo htmlspecialchars($cours['description']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm"><?php echo $cours['nbre_inscriptions']; ?> étudiants</div>
                            </td>
                            <td class="px-6 py-4">
                                <button type="button" 
                                            onclick="ouvrirModalModifierCours(<?php echo htmlspecialchars(json_encode($cours)); ?>)" 
                                            class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                <form method="POST" action="supprimercours.php?id=<?php echo $cours['idcours']; ?>" class="inline">
                                    <input type="hidden" name="cours_id" value="<?php echo $cours['idcours']; ?>">
                                    
                                    <button type="submit" name="supprcours"
                                            value="supprimerCours" 
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')"
                                            class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>