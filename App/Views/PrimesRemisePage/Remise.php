<?php
// App/Views/RemisesPage/RemisesCalculated.php
?>
<main class="p-6">
    <div class="container mx-auto">
        <!-- Titre -->
        <div class="flex items-center justify-between mb-6">

            <h1 class="text-3xl font-bold mb-6 text-gray-800 flex items-center space-x-2">
                <!-- Icône SVG -->
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16M4 12h16M4 20h16" />
                </svg>

                <span>Gestion des Remise</span>
            </h1>
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
        <!-- Bouton Ajouter une catégorie -->
        <!-- <div class="flex items-center justify-end">
        <button class="bg-blue-600 hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md flex items-end justify-end space-x-2" onclick="toggleModal('addCategoryModal')"> -->
        <!-- Icône SVG -->
        <!-- <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg> -->
        <!-- <span>Génération de PDF</span>
        </button>
        </div> -->
        </br>

        <!-- Tableau des catégories -->
        <h1 class="text-3xl font-bold mb-6 text-gray-800 flex items-center space-x-2">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16M4 12h16M4 20h16" />
            </svg>
            <span>Remises Calculées</span>
        </h1>
        <div class="mb-4 flex items-center space-x-4">
            <div class="relative w-[30%]">
                <input 
                    type="text" 
                    id="searchInput" 
                    placeholder="Rechercher par nom ou année" 
                    class="w-full px-3 py-2 border rounded-md pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <!-- Icone de recherche -->
                <svg 
                    xmlns="http://www.w3.org/2000/svg" 
                    class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-500" 
                    fill="none" 
                    viewBox="0 0 24 24" 
                    stroke="currentColor"
                >
                    <path 
                        stroke-linecap="round" 
                        stroke-linejoin="round" 
                        stroke-width="2" 
                        d="M11 4a7 7 0 011.405 13.834l3.674 3.675a1 1 0 01-1.415 1.414l-3.675-3.674A7 7 0 1111 4z"
                    />
                </svg>
            </div>
        </div>
        <br>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="table-auto w-full border-collapse border" id="RemiseTable">
                <thead>
                    <tr class="bg-blue-600 text-white uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left border">Nom du Client</th>
                        <th class="py-3 px-6 text-left border">Total des Achats</th>
                        <th class="py-3 px-6 text-center border">Remises</th>
                        <th class="py-3 px-6 text-center border">Année</th>
                        <th class="py-3 px-6 text-center border">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($remises as $remise): ?>
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-6 text-left"><?= htmlspecialchars($remise->getClientName() ?? $remise->getIdClient()) ?></td>
                        <td class="py-3 px-6 text-left"><?= number_format($remise->getTotalAchats(), 0) ?> €</td>
                        <td class="py-3 px-6 text-left"><?= number_format($remise->getRemise(), 0) ?> €</td>
                        <td class="py-3 px-6 text-center"><?= htmlspecialchars($remise->getannee()) ?></td>
                        <td class="py-3 px-6 text-center">
                            <button onclick="deleteremise(<?= $remise->getId() ?>, <?= $remise->getIdClient() ?>)" class="text-red-600 hover:text-red-900">
                                Supprimer
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function filterTable() {
            const searchInput = document.getElementById('searchBar').value.toLowerCase();
            const table = document.getElementById('RemiseTable');
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
    </script>

    <!-- <script>
        function openEditCategoryModal(category) {
            document.getElementById('editCategoryId').value = category.id || '';
            document.getElementById('editCategoryNom').value = category.nom || '';
            document.getElementById('editCategoryDescription').value = category.description || '';
            toggleModal('editCategoryModal');
        }
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function () {
            const searchValue = this.value.toLowerCase();
            const table = document.getElementById('commercialsTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            for (let row of rows) {
                const commercialName = row.cells[0].textContent.toLowerCase();
                const year = row.cells[3].textContent;

                if (commercialName.includes(searchValue) || year.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
        function deleteremise(remiseId, clientId) {
            const clientName = event.target.closest('tr').cells[1].textContent; // Get client name from the row
            console.log(remiseId, clientId);
            if (confirm(`Êtes-vous sûr de vouloir supprimer la remise pour ${clientName} ?`)) {
                fetch('/Remise/delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        remiseId: remiseId,
                        clientId: clientId
                    })
                })
                .then(response => {
                    response.clone().text().then(rawText => {
                        console.log('Raw response text:', rawText);
                    });
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert('Remise supprimée avec succès');
                        location.reload();
                    } else {
                        alert(data.message || 'Erreur lors de la suppression de la remise');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Une erreur est survenue lors de la suppression');
                });
            }
        }
    </script>
</main>
