<main class="p-6">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Liste des Commandes</h1>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="table-auto w-full border-collapse border">
                <thead>
                    <tr class="bg-blue-600 text-white uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left border">ID Commande</th>
                        <th class="py-3 px-6 text-left border">Client</th>
                        <th class="py-3 px-6 text-left border">Date</th>
                        <th class="py-3 px-6 text-left border">Total</th>
                        <th class="py-3 px-6 text-center border">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm font-medium">
                    <?php foreach ($commandes as $commande): ?>
                    <tr class="hover:bg-gray-100 transition-colors duration-200">
                        <td class="py-3 px-6 border"><?= htmlspecialchars($commande['id']) ?></td>
                        <td class="py-3 px-6 border"><?= htmlspecialchars($commande['client_nom']) . ' ' . htmlspecialchars($commande['client_prenom']) ?></td>
                        <td class="py-3 px-6 border"><?= htmlspecialchars($commande['date']) ?></td>
                        <td class="py-3 px-6 border"><?= htmlspecialchars($commande['total']) ?> DH</td>
                        <td class="py-3 px-6 text-center border space-x-2">
                            <!-- Bouton pour imprimer la facture -->
                            <a href="/Commande/imprime?id=<?= htmlspecialchars($commande['id']) ?>" 
           class="text-blue-500 hover:text-blue-700 flex items-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8"></path>
            </svg>
            Imprimer
        </a>
                            <!-- Bouton pour afficher les produits -->
                            <button class="text-green-500 hover:text-green-700 flex items-center" onclick="openProductsModal(<?= htmlspecialchars(json_encode($commande)) ?>)">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Voir Produits
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Produits -->
    <div id="productsModal" class="modal hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-6 w-96">
            <h2 class="text-lg font-bold mb-4">Produits de la Commande</h2>
            <div id="productsList" class="text-gray-700">
                <!-- Liste des produits sera chargée ici -->
            </div>
            <div class="flex justify-end mt-4">
                <button class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg" onclick="toggleModal('productsModal')">Fermer</button>
            </div>
        </div>
    </div>

    <script>
   function openProductsModal(commande) {
    fetch(`/Commande/produits?id=${commande.id}`)
    .then(response => response.json())
    .then(data => {
        console.log('Produits récupérés:', data); // Vérifiez les données ici
        const productsList = document.getElementById('productsList');
        productsList.innerHTML = '';
        data.forEach(product => {
            productsList.innerHTML += `
                <div class="border-b py-2">
                    <p><strong>Nom:</strong> ${product.nom || 'N/A'}</p>
                    <p><strong>Quantité:</strong> ${product.quantity || 0}</p>
                    <p><strong>Prix:</strong> ${product.prix ? product.prix + ' DH' : 'N/A'}</p>
                </div>
            `;
        });
        toggleModal('productsModal');
    })
    .catch(error => console.error('Erreur lors du chargement des produits:', error));

}


        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }
    </script>
</main>
