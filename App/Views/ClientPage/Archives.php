<main class="p-6">
    <div class="container mx-auto">
        <div class="flex items-center justify-between mb-6">

            <h1 class="text-3xl font-bold mb-6 text-gray-800">Archives des Clients</h1>
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
            <table class="table-auto w-full border-collapse border" id="ClientArchiveTable">
                <thead>
                    <tr class="bg-red-600 text-white uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left border">ID</th>
                        <th class="py-3 px-6 text-left border">Nom</th>
                        <th class="py-3 px-6 text-left border">Prénom</th>
                        <th class="py-3 px-6 text-left border">Adresse</th>
                        <th class="py-3 px-6 text-left border">Ville</th>
                        <th class="py-3 px-6 text-center border">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm font-medium">
                    <?php foreach ($deletedClients as $client): ?>
                        <tr class="hover:bg-gray-100 transition-colors duration-200">
                            <td class="py-3 px-6 border"><?= htmlspecialchars($client['id']) ?></td>
                            <td class="py-3 px-6 border"><?= htmlspecialchars($client['nom']) ?></td>
                            <td class="py-3 px-6 border"><?= htmlspecialchars($client['prenom']) ?></td>
                            <td class="py-3 px-6 border"><?= htmlspecialchars($client['adresse']) ?></td>
                            <td class="py-3 px-6 border"><?= htmlspecialchars($client['ville']) ?></td>
                            <td class="py-3 px-6 text-center border">
                                <form method="POST" action="/Client/restore" onsubmit="return confirmRestore(this);">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($client['id']) ?>">
                                    <button type="submit"
                                        class="bg-green-600 hover:bg-green-500 text-white py-2 px-4 rounded-lg">
                                        Restaurer
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmRestore(form) {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Le client sera restauré.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, restaurer !',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
        return false; // Empêcher la soumission par défaut
    }
    function filterTable() {
        const searchInput = document.getElementById('searchBar').value.toLowerCase();
        const table = document.getElementById('ClientArchiveTable');
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