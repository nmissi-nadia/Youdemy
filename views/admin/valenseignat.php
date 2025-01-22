<!-- Validation des comptes enseignants -->
                    <div class="bg-white p-4 rounded-lg shadow-md mb-6 justify-center">
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
                              
                              $enseignantsEnAttente = $admin->obtenirEnseignantsEnAttente();
                              foreach ($enseignantsEnAttente as $ligne) {
                                  echo "<tr>";
                                  echo "<td class='py-2'>{$ligne['nom']}</td>";
                                  echo "<td class='py-2'>{$ligne['email']}</td>";
                                  echo "<td class='py-2'><a href='valider_enseignant.php?id={$ligne['iduser']}' class='bg-green-500 text-white px-4 py-2 rounded'>Valider</a></td>";
                                  echo "</tr>";
                              }
                                ?>
                            </tbody>
                        </table>
                    </div>