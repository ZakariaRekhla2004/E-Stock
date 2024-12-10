<?php
// App/Views/PrimesRemisePage/PrimesCalculated.php
?>
<main class="p-6">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 flex items-center space-x-2">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16M4 12h16M4 20h16" />
            </svg>
            <span>Primes Calculées</span>
        </h1>
        <div class="flex items-center justify-end">
            <!-- <button
                class="bg-blue-600 hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md flex items-end justify-end space-x-2"
                onclick="toggleModal('addCategoryModal')">
                <!-- Icône SVG -->
            <!-- <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg> -->
            <button
                class="bg-blue-600 hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md flex items-end justify-end space-x-2"
                onclick="window.open('/PdfController/generatePdf', '_blank');">
                <span>Génération de PDF</span>
            </button>
            <!-- <span>Génération de PDF</span> -->
            <!-- </button> -->
        </div>
        <br>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="table-auto w-full border-collapse border">
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


    
</main>