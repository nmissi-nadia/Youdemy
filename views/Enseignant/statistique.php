<!-- Stats rapides -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <?php foreach ($statistiques as $stat): ?>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="ml-4">
                        <div class="text-sm text-gray-500"><?php echo htmlspecialchars($stat['titre']); ?></div>
                        <div class="text-2xl font-semibold"><?php echo htmlspecialchars($stat['nb_inscriptions']); ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>