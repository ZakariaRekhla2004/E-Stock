<main class="p-6">
    <div class="container mx-auto">
        <!-- Titre -->
        <h1 class="text-3xl font-bold mb-6 text-gray-800 flex items-center space-x-2">
            <!-- Icône SVG -->
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16M4 12h16M4 20h16" />
</svg>

            <span>Gestion des Catégories</span>
        </h1>

        <!-- Bouton Ajouter une catégorie -->
        <button class="bg-blue-600 hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md flex items-center space-x-2" onclick="toggleModal('addCategoryModal')">
            <!-- Icône SVG -->
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>Ajouter Catégorie</span>
        </button>

        </br>

        <!-- Tableau des catégories -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="table-auto w-full border-collapse border">
                <thead>
                    <tr class="bg-blue-600 text-white uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left border">ID</th>
                        <th class="py-3 px-6 text-left border">Nom</th>
                        <th class="py-3 px-6 text-left border">Description</th>
                        <th class="py-3 px-6 text-center border">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm font-medium">
                    <?php foreach ($categories as $category): ?>
                    <tr class="hover:bg-gray-100 transition-colors duration-200">
                        <td class="py-3 px-6 border"><?= htmlspecialchars($category->getId()) ?></td>
                        <td class="py-3 px-6 border"><?= htmlspecialchars($category->getNom()) ?></td>
                        <td class="py-3 px-6 border"><?= htmlspecialchars($category->getDescription()) ?></td>
                        <td class="py-3 px-6 text-center border flex justify-center space-x-4">
                            <!-- Modifier bouton -->
                            <button class="text-green-500 hover:text-green-700 flex items-center" onclick='openEditCategoryModal(<?= json_encode([
                                'id' => $category->getId(),
                                'nom' => $category->getNom(),
                                'description' => $category->getDescription(),
                            ]) ?>)'>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536-12.02 12.02H3v-3.536l12.02-12.02zM17.768 2.732a2.5 2.5 0 113.536 3.536L18.5 8.072 15.232 4.804l2.536-2.536z" />
                                </svg>
                            </button>

                            <form method="POST" action="/Category/delete" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ? Cette action est irréversible.')">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($category->getId()) ?>">
                                <button type="submit" class="text-red-500 hover:text-red-700 flex items-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L6 6M10 6h4m4 0h2m-2 0v12a2 2 0 01-2 2H8a2 2 0 01-2-2V6m14 0H4" />
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Ajouter -->
    <div id="addCategoryModal" class="modal hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-6 w-96">
            <h2 class="text-lg font-bold mb-4">Ajouter une Catégorie</h2>
            <form method="POST" action="/Category/add">
                <div class="mb-4">
                    <label for="nom" class="block text-sm font-semibold mb-2">Nom</label>
                    <input type="text" name="nom" placeholder="Entrez le nom" class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-semibold mb-2">Description</label>
                    <textarea name="description" placeholder="Entrez la description" class="w-full border rounded-lg px-3 py-2" required></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg" onclick="toggleModal('addCategoryModal')">Annuler</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white py-2 px-4 rounded-lg">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal Modifier -->
    <div id="editCategoryModal" class="modal hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-6 w-96">
            <h2 class="text-lg font-bold mb-4">Modifier une Catégorie</h2>
            <form id="editCategoryForm" method="POST" action="/Category/edit">
                <input type="hidden" name="id" id="editCategoryId">
                <div class="mb-4">
                    <label for="nom" class="block text-sm font-semibold mb-2">Nom</label>
                    <input type="text" name="nom" id="editCategoryNom" placeholder="Entrez le nom" class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-semibold mb-2">Description</label>
                    <textarea name="description" id="editCategoryDescription" placeholder="Entrez la description" class="w-full border rounded-lg px-3 py-2" required></textarea>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg" onclick="toggleModal('editCategoryModal')">Annuler</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white py-2 px-4 rounded-lg">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditCategoryModal(category) {
            document.getElementById('editCategoryId').value = category.id || '';
            document.getElementById('editCategoryNom').value = category.nom || '';
            document.getElementById('editCategoryDescription').value = category.description || '';
            toggleModal('editCategoryModal');
        }
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }
    </script>
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
