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

        <!-- Filter by Action Dropdown Button -->
        <div class="relative mb-3">
            <button onclick="toggleDropdown()"
                class="bg-blue-600 text-white py-2 px-4 rounded-md flex items-center space-x-2">
                <span>Filtrer par Action</span>
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div id="dropdown-menu"
                class="hidden absolute mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                <div class="py-1" role="none">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 flex items-center space-x-2"
                        role="menuitem" tabindex="-1" id="menu-item-0" onclick="filterByAction('CREATE')">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z"
                                clip-rule="evenodd" />
                        </svg>

                        <span>Create</span>
                    </a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 flex items-center space-x-2"
                        role="menuitem" tabindex="-1" id="menu-item-1" onclick="filterByAction('UPDATE')">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z"
                                clip-rule="evenodd" />
                            <path fill-rule="evenodd"
                                d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z"
                                clip-rule="evenodd" />
                        </svg>

                        <span>Update</span>
                    </a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 flex items-center space-x-2"
                        role="menuitem" tabindex="-1" id="menu-item-2" onclick="filterByAction('DELETE')">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                clip-rule="evenodd" />
                        </svg>

                        <span>Delete</span>
                    </a>
                </div>
            </div>
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

    function filterByAction(action) {
        const actionFilter = action.toLowerCase();
        const searchInput = document.getElementById('searchBar').value.toLowerCase();
        const table = document.getElementById('auditTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            let match = false;

            // Search filter
            for (let j = 0; j < cells.length; j++) {
                if (cells[j] && cells[j].innerText.toLowerCase().includes(searchInput)) {
                    match = true;
                    break;
                }
            }

            // Action filter
            const actionCell = cells[2];  // Action column is the third one
            if (actionFilter && actionCell && !actionCell.innerText.toLowerCase().includes(actionFilter)) {
                match = false;
            }

            rows[i].style.display = match ? '' : 'none';
        }
    }

    function toggleDropdown() {
        const dropdownMenu = document.getElementById('dropdown-menu');
        dropdownMenu.classList.toggle('hidden');
    }
</script>