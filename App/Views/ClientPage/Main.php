<main class="p-6 ">
    <div class="container mx-auto">
        <!-- Titre -->
        <h1 class="text-3xl font-bold mb-6 text-gray-800 flex items-center space-x-2">
            <!-- Icône SVG -->
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-1a4 4 0 00-4-4H6a4 4 0 00-4 4v1h5m10 0H7m4-16a4 4 0 110 8 4 4 0 010-8z"></path>
            </svg>
            <span>Gestion des Clients</span>
        </h1>

        <?php if (App\Config\Auth::hasRole([
            App\Model\Enums\UserRoles::COMERCIAL->value,
            App\Model\Enums\UserRoles::ADMIN->value,
        ])) { ?>
        <!-- Bouton Ajouter un client -->
        <button
            class="bg-blue-600 hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md flex items-center space-x-2"
            onclick="toggleModal('addClientModal')">
            <!-- Icône SVG -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Ajouter Client</span>
        </button>
        <?php } ?>

        </br>

        <!-- Tableau des clients -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="table-auto w-full border-collapse border">
                <thead>
                    <tr class="bg-blue-600 text-white uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left border">ID</th>
                        <th class="py-3 px-6 text-left border">Nom</th>
                        <th class="py-3 px-6 text-left border">Prénom</th>
                        <th class="py-3 px-6 text-left border">Adresse</th>
                        <th class="py-3 px-6 text-left border">Ville</th>
                        <?php if (App\Config\Auth::hasRole([
                            App\Model\Enums\UserRoles::COMERCIAL->value,
                            App\Model\Enums\UserRoles::ADMIN->value,
                        ])) { ?>
                        <th class="py-3 px-6 text-center border">Actions</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm font-medium">
                    <?php foreach ($clients as $client): ?>
                    <tr class="hover:bg-gray-100 transition-colors duration-200">
                        <td class="py-3 px-6 border"><?= htmlspecialchars($client->getId()) ?></td>
                        <td class="py-3 px-6 border"><?= htmlspecialchars($client->getNom()) ?></td>
                        <td class="py-3 px-6 border"><?= htmlspecialchars($client->getPrenom()) ?></td>
                        <td class="py-3 px-6 border"><?= htmlspecialchars($client->getAdresse()) ?></td>
                        <td class="py-3 px-6 border"><?= htmlspecialchars($client->getVille()) ?></td>
                        <?php if (App\Config\Auth::hasRole([
                            App\Model\Enums\UserRoles::COMERCIAL->value,
                            App\Model\Enums\UserRoles::ADMIN->value,
                        ])) { ?>
                        <td class="py-3 px-6 text-center border flex justify-center space-x-4">
                            <!-- Modifier bouton -->
                            <button class="text-green-500 hover:text-green-700 flex items-center"
                                onclick='openEditModal(<?= json_encode([
        'id'=> $client->getId(),
                                'nom' => $client->getNom(),
                                'prenom' => $client->getPrenom(),
                                'adresse' => $client->getAdresse(),
                                'ville' => $client->getVille(),
                                ]) ?>)'>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536-12.02 12.02H3v-3.536l12.02-12.02zM17.768 2.732a2.5 2.5 0 113.536 3.536L18.5 8.072 15.232 4.804l2.536-2.536z" />
                                </svg>
                            </button>




                            <form method="POST" action="/Client/delete"
                                onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce client ? Cette action est irréversible.')">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($client->getId()) ?>">
                                <button type="submit" class="text-red-500 hover:text-red-700 flex items-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L6 6M10 6h4m4 0h2m-2 0v12a2 2 0 01-2 2H8a2 2 0 01-2-2V6m14 0H4" />
                                    </svg>
                                </button>
                            </form>


                        </td>
                        <?php } ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if (App\Config\Auth::hasRole([
        App\Model\Enums\UserRoles::COMERCIAL->value,
        App\Model\Enums\UserRoles::ADMIN->value,
    ])) { ?>
    <!-- Modal Ajouter -->
    <div id="addClientModal"
        class="modal hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-6 w-96">
            <h2 class="text-lg font-bold mb-4">Ajouter un Client</h2>
            <form method="POST" action="/Client/add">
                <div class="mb-4">
                    <label for="nom" class="block text-sm font-semibold mb-2">Nom</label>
                    <input type="text" name="nom" placeholder="Entrez le nom"
                        class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="prenom" class="block text-sm font-semibold mb-2">Prénom</label>
                    <input type="text" name="prenom" placeholder="Entrez le prénom"
                        class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="adresse" class="block text-sm font-semibold mb-2">Adresse</label>
                    <input type="text" name="adresse" placeholder="Entrez l'adresse"
                        class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="ville" class="block text-sm font-semibold mb-2">Ville</label>
                    <input type="text" name="ville" placeholder="Entrez la ville"
                        class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg"
                        onclick="toggleModal('addClientModal')">Annuler</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white py-2 px-4 rounded-lg">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal Modifier -->
    <div id="editClientModal"
        class="modal hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-6 w-96">
            <h2 class="text-lg font-bold mb-4">Modifier un Client</h2>
            <form id="editClientForm" method="POST" action="/Client/edit">
                <input type="hidden" name="id" id="editId">
                <div class="mb-4">
                    <label for="nom" class="block text-sm font-semibold mb-2">Nom</label>
                    <input type="text" name="nom" id="editNom" placeholder="Entrez le nom"
                        class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="prenom" class="block text-sm font-semibold mb-2">Prénom</label>
                    <input type="text" name="prenom" id="editPrenom" placeholder="Entrez le prénom"
                        class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="adresse" class="block text-sm font-semibold mb-2">Adresse</label>
                    <input type="text" name="adresse" id="editAdresse" placeholder="Entrez l'adresse"
                        class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="ville" class="block text-sm font-semibold mb-2">Ville</label>
                    <input type="text" name="ville" id="editVille" placeholder="Entrez la ville"
                        class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg"
                        onclick="toggleModal('editClientModal')">Annuler</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white py-2 px-4 rounded-lg">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php } ?>

    
</main>

<script>
    // Afficher ou masquer un modal
    // Afficher ou masquer un modal
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);

        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    // Exemple d'ouverture du modal de modification
    function openEditModal(client) {
        console.log("Client reçu :", client);

        // Remplir les champs du formulaire avec les données du client
        document.getElementById('editId').value = client.id || '';
        document.getElementById('editNom').value = client.nom || '';
        document.getElementById('editPrenom').value = client.prenom || '';
        document.getElementById('editAdresse').value = client.adresse || '';
        document.getElementById('editVille').value = client.ville || '';

        // Afficher le modal
        toggleModal('editClientModal');
    }
</script>
<script>
    <?php if (!empty($_SESSION['error_message'])): ?>
    Swal.fire({
        icon: 'error',
        title: 'Erreur',
        text: '<?= addslashes($_SESSION['error_message']) ?>',
    });
    <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success_message'])): ?>
    Swal.fire({
        icon: 'success',
        title: 'Succès',
        text: '<?= addslashes($_SESSION['success_message']) ?>',
    });
    <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
</script>
