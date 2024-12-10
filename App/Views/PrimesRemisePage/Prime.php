<?php
// App/Views/PrimesRemisePage/PrimesCalculated.php
?>
<main class="p-6">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 flex items-center space-x-2">
            <!-- Icône SVG -->
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16M4 12h16M4 20h16" />
            </svg>
            <span>Gestion des Primes</span>
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16M4 12h16M4 20h16" />
            </svg>
            <span>Primes Calculées</span>
        </h1>
        <div class="flex items-center justify-between mb-6">

            <!-- Bouton Ajouter une catégorie -->
            <button
                class="bg-blue-600 hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md flex items-end justify-end space-x-2"
                onclick="toggleModal('addCategoryModal')">
                <!-- Icône SVG -->
                <!-- <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <div class="flex items-center justify-center w-full">
        <div class="mb-4 flex items-center justify-start space-x-4 w-[35%] ">
            <div class="relative w-full">
                <input type="text" id="searchInput" placeholder="Rechercher par nom ou année"
                    class="w-full px-3 py-2 border rounded-md pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <!-- Icone de recherche -->
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 4a7 7 0 011.405 13.834l3.674 3.675a1 1 0 01-1.415 1.414l-3.675-3.674A7 7 0 1111 4z" />
                </svg>
            </div>
        </div>
            <!-- <button
                class="bg-blue-600 hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md flex items-end justify-end space-x-2"
                onclick="toggleModal('addCategoryModal')">
                <!-- Icône SVG -->
            <!-- <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg> -->
                <span>Génération de PDF</span>
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
        <div class="flex items-center justify-end w-full">
        <button 
    onclick="window.location.href='/primes/pdf'"
    class="bg-blue-600 hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md flex items-end justify-end space-x-2"
    >
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
    </svg>
    <span>Génération de PDF</span>
</button>
        
            <!-- <span>Génération de PDF</span> -->
            <!-- </button> -->
        </div>
        </div>

        <br>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="table-auto w-full border-collapse border" id="PrimeTable">
            <table id="commercialsTable" class="table-auto w-full border-collapse border">
                <thead>
                    <tr class="bg-blue-600 text-white uppercase text-sm leading-normal">
                        <!-- <th class="py-3 px-6 text-left border">ID</th> -->
                        <th class="py-3 px-6 text-left border">Nom du Commercial</th>
                        <th class="py-3 px-6 text-left border">Chiffre d'Affaire</th>
                        <th class="py-3 px-6 text-left border">Prime</th>
                        <th class="py-3 px-6 text-left border">Année</th>
                        <th class="py-3 px-6 text-center border">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($primes as $prime): ?>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-3 px-6 text-left">
                                <?= htmlspecialchars($prime->getCommercialName() ?? $prime->getIdCommercial()) ?>
                            </td>
                            <td class="py-3 px-6 text-left"><?= number_format($prime->getChiffreAffaire(), 0) ?> €</td>
                            <td class="py-3 px-6 text-left"><?= number_format($prime->getPrime(), 0) ?> €</td>
                            <td class="py-3 px-6 text-left"><?= htmlspecialchars($prime->getYear()) ?></td>
                            <td class="py-3 px-6 text-center">
                                <form method="POST" action="/Prime/delete"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette prime ? Cette action est irréversible.')">
                                    <input type="hidden" name="primeId" value="<?= htmlspecialchars($prime->getId()) ?>">
                                    <input type="hidden" name="idCommercial"
                                        value="<?= htmlspecialchars($prime->getIdCommercial()) ?>">
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        Supprimer
                                    </button>
                                </form>
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
            const table = document.getElementById('PrimeTable');
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
        }
    </script> -->
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
    </script>

</main>