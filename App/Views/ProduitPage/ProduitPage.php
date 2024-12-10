<main class="p-6">
    <div class="container mx-auto">
        <!-- Titre -->
        <h1 class="text-3xl font-bold mb-6 text-gray-800 flex items-center space-x-2">
            <!-- Icône SVG -->
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16M4 12h16M4 20h16" />
            </svg>
            <span>Gestion des Produits</span>
        </h1>

        <!-- Bouton Ajouter un produit -->
        <div class="flex items-center justify-between mb-6">

            <button
                class="bg-blue-600 hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md flex items-center space-x-2"
                onclick="toggleModal('addProductModal')">
                <!-- Icône SVG -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Ajouter Produit</span>
            </button>
            <div class="flex items-center space-x-2 border border-gray-300 rounded-lg px-2 py-1">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 4a7 7 0 100 14 7 7 0 000-14zm10 10l-3.867-3.867"></path>
                </svg>
                <input type="text" id="searchBar" placeholder="Rechercher..."
                    class="w-64 p-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                    onkeyup="filterTable()" />
            </div>
        </div>

        </br>

        <!-- Tableau des produits -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="table-auto w-full border-collapse border" id="ProduitTable">
                <thead>
                    <tr class="bg-blue-600 text-white uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left border">ID</th>
                        <th class="py-3 px-6 text-left border">Image</th>
                        <th class="py-3 px-6 text-left border">Désignation</th>
                        <th class="py-3 px-6 text-left border">Prix</th>
                        <th class="py-3 px-6 text-left border">Quantité</th>
                        <th class="py-3 px-6 text-left border">Catégorie</th>
                        <th class="py-3 px-6 text-center border">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm font-medium">
                    <?php foreach ($produits as $product): ?>
                        <tr class="hover:bg-gray-100 transition-colors duration-200">
                            <td class="py-3 px-6 border"><?= htmlspecialchars($product->getId()) ?></td>
                            <td class="py-3 px-6 border">
                                <img src="/E-Stock/public/<?= htmlspecialchars($product->getPathImage()) ?>"
                                    alt="Image du produit" class="w-32 h-32 object-cover" />
                            </td>

                            <td class="py-3 px-6 border"><?= htmlspecialchars($product->getDesignation()) ?></td>
                            <td class="py-3 px-6 border"><?= htmlspecialchars($product->getPrix()) ?> MAD</td>
                            <td class="py-3 px-6 border"><?= htmlspecialchars($product->getQtt()) ?></td>
                            <?php
                            // Appel à la méthode getCategoryById pour récupérer le nom de la catégorie
                            $categoryName = $categorieDAO->getCategoryById($product->getIdCategorie());
                            ?>
                            <td class="py-3 px-6 border"><?= htmlspecialchars($categoryName) ?></td>
                            <td class="py-3 px-6 text-center border flex justify-center space-x-4">
                                <!-- Modifier bouton -->
                                <button class="text-green-500 hover:text-green-700 flex items-center" onclick='openEditProductModal(<?= json_encode([
                                    'id' => $product->getId(),
                                    'pathImage' => $product->getPathImage(),
                                    'designation' => $product->getDesignation(),
                                    'prix' => $product->getPrix(),
                                    'qtt' => $product->getQtt(),
                                    'idCategorie' => $product->getIdCategorie(),
                                ]) ?>)'>
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536-12.02 12.02H3v-3.536l12.02-12.02zM17.768 2.732a2.5 2.5 0 113.536 3.536L18.5 8.072 15.232 4.804l2.536-2.536z" />
                                    </svg>
                                </button>

                                <!-- Supprimer bouton -->
                                <form method="POST" action="/Product/delete"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($product->getId()) ?>">
                                    <button type="submit" class="text-red-500 hover:text-red-700 flex items-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L6 6M10 6h4m4 0h2m-2 0v12a2 2 0 01-2 2H8a2 2 0 01-2-2V6m14 0H4" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Edit Modal -->
            <div id="editProductModal"
                class="modal hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-md p-6 w-96">
                    <h2 class="text-lg font-bold mb-4">Modifier un Produit</h2>
                    <form method="POST" action="/Product/edit" enctype="multipart/form-data">
                        <input type="hidden" id="editProductId" name="id">
                        <div class="mb-4">
                            <label for="editProductImage" class="block text-sm font-semibold mb-2">Image</label>
                            <input type="file" id="editProductImage" name="pathImage"
                                class="w-full border rounded-lg px-3 py-2" accept="image/*">
                        </div>
                        <div class="mb-4">
                            <label for="editProductDesignation"
                                class="block text-sm font-semibold mb-2">Désignation</label>
                            <input type="text" id="editProductDesignation" name="designation"
                                class="w-full border rounded-lg px-3 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label for="editProductPrix" class="block text-sm font-semibold mb-2">Prix</label>
                            <input type="number" id="editProductPrix" name="prix"
                                class="w-full border rounded-lg px-3 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label for="editProductQtt" class="block text-sm font-semibold mb-2">Quantité</label>
                            <input type="number" id="editProductQtt" name="qtt"
                                class="w-full border rounded-lg px-3 py-2" required>
                        </div>
                        <div class="mb-4">
                            <label for="editProductCategory" class="block text-sm font-semibold mb-2">Catégorie</label>
                            <select id="editProductCategory" name="idCategorie"
                                class="w-full border rounded-lg px-3 py-2" required>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= htmlspecialchars($category->getId()) ?>">
                                        <?= htmlspecialchars($category->getNom()) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg"
                                onclick="toggleModal('editProductModal')">Annuler</button>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-500 text-white py-2 px-4 rounded-lg">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Ajouter Modal -->
    <div id="addProductModal"
        class="modal hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-6 w-96">
            <h2 class="text-lg font-bold mb-4">Ajouter un Produit</h2>
            <form method="POST" action="/Product/add" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="pathImage" class="block text-sm font-semibold mb-2">Image</label>
                    <input type="file" name="pathImage" class="w-full border rounded-lg px-3 py-2" accept="image/*"
                        required>
                </div>

                <div class="mb-4">
                    <label for="designation" class="block text-sm font-semibold mb-2">Désignation</label>
                    <input type="text" name="designation" placeholder="Nom du produit"
                        class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="prix" class="block text-sm font-semibold mb-2">Prix</label>
                    <input type="number" name="prix" placeholder="Prix en MAD"
                        class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="qtt" class="block text-sm font-semibold mb-2">Quantité</label>
                    <input type="number" name="qtt" placeholder="Quantité" class="w-full border rounded-lg px-3 py-2"
                        required>
                </div>
                <div class="mb-4">
                    <label for="idCategorie" class="block text-sm font-semibold mb-2">Catégorie</label>
                    <select name="idCategorie" class="w-full border rounded-lg px-3 py-2" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category->getId()) ?>">
                                <?= htmlspecialchars($category->getNom()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg"
                        onclick="toggleModal('addProductModal')">Annuler</button>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-500 text-white py-2 px-4 rounded-lg">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
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

    function openEditProductModal(product) {
        // Vérification dans la console des valeurs passées
        console.log(product);

        // Vérification que les valeurs sont bien définies avant de les affecter
        document.getElementById('editProductId').value = product.id || '';
        document.getElementById('editProductDesignation').value = product.designation || '';
        document.getElementById('editProductPrix').value = product.prix || '';
        document.getElementById('editProductQtt').value = product.qtt || '';
        document.getElementById('editProductCategory').value = product.idCategorie || '';

        // Ouvrir le modal
        toggleModal('editProductModal');
    }

    function filterTable() {
        const searchInput = document.getElementById('searchBar').value.toLowerCase();
        const table = document.getElementById('ProduitTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            let match = false;

            for (let j = 0; j < cells.length; j++) {
                if (cells[j] && cells[j].innerText.toLowerCase().includes(searchInput)) {
                    match = true;
                    break;
                }
            }

            rows[i].style.display = match ? '' : 'none';
        }
    }

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