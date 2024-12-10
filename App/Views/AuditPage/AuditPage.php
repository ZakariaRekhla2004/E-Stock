<main class="p-6">
    <div class="container mx-auto">
        <!-- Titre -->
        <div class="flex items-center justify-between mb-6">
            <!-- Titre -->
            <h1 class="text-3xl font-bold text-gray-800 flex items-center space-x-2">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16M4 12h16M4 20h16" />
                </svg>
                <span>Gestion des Audits</span>
            </h1>

            <!-- Barre de recherche -->
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

        <!-- Tableau des audits -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="table-auto w-full border-collapse border" id="auditTable">
                <thead>
                    <tr class="bg-blue-600 text-white uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left border">ID</th>
                        <th class="py-3 px-6 text-left border">Table</th>
                        <th class="py-3 px-6 text-left border">Action</th>
                        <th class="py-3 px-6 text-left border">Description</th>
                        <th class="py-3 px-6 text-left border">Date</th>
                        <th class="py-3 px-6 text-left border">Utilisateur</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm font-medium">
                    <?php foreach ($audits as $audit): ?>
                        <tr class="hover:bg-gray-100 transition-colors duration-200">
                            <td class="py-3 px-6 border"><?= htmlspecialchars($audit->getId()) ?></td>
                            <td class="py-3 px-6 border"><?= htmlspecialchars($audit->getTableName()) ?></td>
                            <td class="py-3 px-6 border"><?= htmlspecialchars($audit->getActionType()) ?></td>
                            <td class="py-3 px-6 border"><?= htmlspecialchars($audit->getActionDescription()) ?></td>
                            <td class="py-3 px-6 border"><?= htmlspecialchars($audit->getActionDate()) ?></td>
                            <td class="py-3 px-6 border">
                                <?= htmlspecialchars($audit->user_nom) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
    function filterTable() {
        const searchInput = document.getElementById('searchBar').value.toLowerCase();
        const table = document.getElementById('auditTable');
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