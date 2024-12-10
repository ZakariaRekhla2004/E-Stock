
        <?php
// App/Views/PrimesRemisePage/PrimesCalculated.php
?>
<main class="p-6">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 flex items-center space-x-2">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16M4 12h16M4 20h16" />
            </svg>
            <span>Primes Calculées</span>
        </h1>
        <div class="flex items-center justify-end">
        <button class="bg-blue-600 hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md flex items-end justify-end space-x-2" onclick="toggleModal('addCategoryModal')">
            <!-- Icône SVG -->
            <!-- <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg> -->
            <span>Génération de PDF</span>
        </button>
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
                    <td class="py-3 px-6 text-left"><?= htmlspecialchars($prime->getCommercialName() ?? $prime->getIdCommercial()) ?></td>
                        <td class="py-3 px-6 text-left"><?= number_format($prime->getChiffreAffaire(), 0) ?> €</td>
                        <td class="py-3 px-6 text-left"><?= number_format($prime->getPrime(), 0) ?> €</td>
                        <td class="py-3 px-6 text-left"><?= htmlspecialchars($prime->getYear()) ?></td>
                        <td class="py-3 px-6 text-center">
                            <button onclick="deletePrime(<?= $prime->getId() ?>,<?= $prime->getIdCommercial() ?>)" class="text-red-600 hover:text-red-900">
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
        function deletePrime(primeId, idCommercial) {
    const commercialName = event.target.closest('tr').cells[0].textContent;
            console.log(primeId, idCommercial);
    if (confirm(`Êtes-vous sûr de vouloir supprimer la prime de ${commercialName} ?`)) {
        fetch('/Prime/delete', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                primeId: primeId,
                idCommercial: idCommercial
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
                alert('Prime supprimée avec succès');
                location.reload();
            } else {
                alert(data.message || 'Erreur lors de la suppression de la prime');
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