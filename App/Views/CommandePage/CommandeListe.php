<main class="p-6">
    <div class="container mx-auto">
        <div class="flex items-center justify-between mb-6">

            <h1 class="text-3xl font-bold mb-6 text-gray-800">Liste des Commandes</h1>
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

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="table-auto w-full border-collapse border" id="CommandeListeTable">
                <thead>
                    <tr class="bg-blue-600 text-white uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left border">ID Commande</th>
                        <th class="py-3 px-6 text-left border">Client</th>
                        <th class="py-3 px-6 text-left border">Date</th>
                        <th class="py-3 px-6 text-left border">Total</th>
                        <th class="py-3 px-6 text-left border">État</th>
                        
                        <th class="py-3 px-6 text-center border">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm font-medium">
                    <?php foreach ($commandes as $commande): ?>
                    <tr class="hover:bg-gray-100 transition-colors duration-200">
                        <td class="py-3 px-6 border"><?= htmlspecialchars($commande['id']) ?></td>
                        <td class="py-3 px-6 border">
                            <?= htmlspecialchars($commande['client_nom']) . ' ' . htmlspecialchars($commande['client_prenom']) ?>
                        </td>
                        <td class="py-3 px-6 border"><?= htmlspecialchars($commande['date']) ?></td>
                        <td class="py-3 px-6 border"><?= htmlspecialchars($commande['total']) ?> DH</td>
                        <td class="py-3 px-6 border">
                            <select onchange="updateEtat(<?= htmlspecialchars($commande['id']) ?>, this.value)"
                                class="bg-gray-200 p-2 rounded">
                                <option value="confirmé" <?= $commande['etat'] === 'confirmé' ? 'selected' : '' ?>>
                                    Confirmé</option>
                                <option value="annulé" <?= $commande['etat'] === 'annulé' ? 'selected' : '' ?>>Annulé
                                </option>
                                <option value="livré" <?= $commande['etat'] === 'livré' ? 'selected' : '' ?>>Livré
                                </option>
                            </select>
                        </td>

                        <td class="py-3 px-6 text-center border space-x-2">
                            <!-- Bouton pour imprimer la facture -->
                            <a href="javascript:void(0);"
                                onclick="imprimerCommande('<?= htmlspecialchars($commande['id']) ?>')"
                                class="inline-flex items-center justify-center px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 transition duration-300 ease-in-out">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v8m4-4H8"></path>
                                </svg>
                                Imprimer
                            </a>

                            <!-- Bouton pour afficher les produits -->
                            <button
                                class="inline-flex items-center justify-center px-4 py-2 bg-green-500 text-white font-semibold rounded-lg shadow-md hover:bg-green-600 transition duration-300 ease-in-out"
                                onclick="openProductsModal(<?= htmlspecialchars(json_encode($commande)) ?>)">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
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
    <div id="productsModal"
        class="modal hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-6 w-96">
            <h2 class="text-lg font-bold mb-4">Produits de la Commande</h2>
            <div id="productsList" class="text-gray-700">
                <!-- Liste des produits sera chargée ici -->
            </div>
            <div class="flex justify-end mt-4">
                <button class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg"
                    onclick="toggleModal('productsModal')">Fermer</button>
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
                    productsList.innerHTML = ''; // Vider le contenu précédent

                    data.forEach(product => {
                        productsList.innerHTML += `
                    <div class="border-b py-4 flex items-start space-x-4">
                        <!-- Image du produit -->
                        <img 
                            src="/E-Stock/public/${product.pathImage || 'placeholder.png'}" 
                            alt="Image du produit" 
                            class="w-32 h-32 object-cover border rounded-lg"
                        />
                        <!-- Détails du produit -->
                        <div class="text-left">
                            <p><strong>Nom:</strong> ${product.nom || 'N/A'}</p>
                            <p><strong>Quantité:</strong> ${product.quantity || 0}</p>
                            <p><strong>Prix:</strong> ${product.prix ? product.prix + ' DH' : 'N/A'}</p>
                        </div>
                    </div>
                `;
                    });

                    toggleModal('productsModal'); // Affiche le modal
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des produits:', error);
                    const productsList = document.getElementById('productsList');
                    productsList.innerHTML = `
                <p class="text-red-500">Erreur lors du chargement des produits. Veuillez réessayer.</p>
            `;
                });
        }


        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }

        function imprimerCommande(id) {
            // Préparer le contenu à imprimer
            const printWindow = window.open('/Commande/imprime?id=' + id, '_blank');
            printWindow.onload = function() {
                printWindow.print();
            };
        }

        function filterTable() {
            const searchInput = document.getElementById('searchBar').value.toLowerCase();
            const table = document.getElementById('CommandeListeTable');
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

        function updateEtat(idCommande, etat) {
    fetch('/Commande/updateEtat', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ idCommande, etat }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    title: 'Succès',
                    text: data.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    title: 'Erreur',
                    text: data.error,
                    icon: 'error',
                    confirmButtonText: 'Réessayer'
                });
            }
        })
        .catch(error => {
            console.error('Erreur lors de la mise à jour de l\'état :', error);
            Swal.fire({
                title: 'Erreur',
                text: 'Une erreur est survenue. Veuillez réessayer plus tard.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
}


    </script>
</main>
