<main class="p-6 ">
    <div class="container mx-auto">
        <!-- Titre -->
        <h1 class="text-3xl font-bold mb-6 text-gray-800 flex items-center space-x-2">
            <!-- Icône SVG -->
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-1a4 4 0 00-4-4H6a4 4 0 00-4 4v1h5m10 0H7m4-16a4 4 0 110 8 4 4 0 010-8z"></path>
            </svg>
            <span>Gestion des Utilisateurs</span>
        </h1>


        <!-- Bouton Ajouter un user -->
        <div class="flex items-center justify-between mb-6">

            <button
                class="bg-blue-600 hover:bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md flex items-center space-x-2"
                onclick="toggleModal('addUserModal')">
                <!-- Icône SVG -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>Ajouter Utilisateur</span>
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

        <!-- Tableau des users -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="table-auto w-full border-collapse border" id="UserTable">
                <thead>
                    <tr class="bg-blue-600 text-white uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left border">ID</th>
                        <th class="py-3 px-6 text-left border">Nom</th>
                        <th class="py-3 px-6 text-left border">Prénom</th>
                        <th class="py-3 px-6 text-left border">Email</th>
                        <th class="py-3 px-6 text-left border">Role</th>
                        <th class="py-3 px-6 text-center border">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm font-medium">
                    <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-gray-100 transition-colors duration-200">
                            <td class="py-3 px-6 border"><?= htmlspecialchars($user->getId()) ?></td>
                            <td class="py-3 px-6 border"><?= htmlspecialchars($user->getNom()) ?></td>
                            <td class="py-3 px-6 border"><?= htmlspecialchars($user->getPrenom()) ?></td>
                            <td class="py-3 px-6 border"><?= htmlspecialchars($user->getEmail()) ?></td>
                            <td class="py-3 px-6 border"><?= htmlspecialchars($user->getRole()) ?></td>
                            <td class="py-3 px-6 text-center border flex justify-center space-x-4">
                                <!-- Modifier bouton -->
                                <button class="text-green-500 hover:text-green-700 flex items-center" onclick='openEditModal(<?= json_encode([
                                    'id' => $user->getId(),
                                    'nom' => $user->getNom(),
                                    'prenom' => $user->getPrenom(),
                                    'email' => $user->getEmail(),
                                    'role' => $user->getRole(),
                                ]) ?>)'>
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536-12.02 12.02H3v-3.536l12.02-12.02zM17.768 2.732a2.5 2.5 0 113.536 3.536L18.5 8.072 15.232 4.804l2.536-2.536z" />
                                    </svg>
                                </button>




                                <form method="POST" action="/user/delete"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce user ? Cette action est irréversible.')">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($user->getId()) ?>">
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
        </div>
    </div>
    <!-- Modal Ajouter -->
    <div id="addUserModal"
        class="modal hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-6 w-96">
            <h2 class="text-lg font-bold mb-4">Ajouter un Utilisateur</h2>
            <form method="POST" action="/user/add">
                <div class="mb-4">
                    <label for="nom" class="block text-sm font-semibold mb-2">Nom</label>
                    <input type="text" name="nom" placeholder="Entrez le nom" class="w-full border rounded-lg px-3 py-2"
                        required>
                </div>
                <div class="mb-4">
                    <label for="prenom" class="block text-sm font-semibold mb-2">Prénom</label>
                    <input type="text" name="prenom" placeholder="Entrez le prénom"
                        class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold mb-2">Email</label>
                    <input type="text" name="email" placeholder="Entrez l'email"
                        class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold mb-2">Mot de passe</label>
                    <input type="password" name="password" placeholder="Entrez le mot de passe"
                        class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="role" class="block text-sm font-semibold mb-2">Role</label>
                    <select name="role" class="w-full border rounded-lg px-3 py-2" required>
                        <option value="ADMIN">Admin</option>
                        <option value="RH">RH</option>
                        <option value="COMERCIAL">COMERCIAL</option>
                        <option value="ACHAT">ACHAT</option>
                        <option value="DIRECTION">DIRECTION</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg"
                        onclick="toggleModal('addUserModal')">Annuler</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white py-2 px-4 rounded-lg">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal Modifier -->
    <div id="editUserModal"
        class="modal hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-md p-6 w-96">
            <h2 class="text-lg font-bold mb-4">Modifier un Utilisateur</h2>
            <form id="editUserForm" method="POST" action="/user/edit">
                <input type="hidden" name="id" id="editId">
                <div class="mb-4">
                    <label for="nom" class="block text-sm font-semibold mb-2">Nom</label>
                    <input type="text" name="nom" id="editNom" placeholder="Entrez le nom"
                        class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="prenom" class="block text-sm font-semibold mb-2">Prénom</label>
                    <input type="text" name="prenom" id="editPrenom" placeholder="Entrez le prénom"
                        class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold mb-2">Email</label>
                    <input type="email" name="email" id="editEmail" placeholder="Entrez l'email"
                        class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label for="role" class="block text-sm font-semibold mb-2">Role</label>
                    <select name="role" id="editRole" class="w-full border rounded-lg px-3 py-2" required>
                        <option value="ADMIN">Admin</option>
                        <option value="RH">RH</option>
                        <option value="COMERCIAL">COMERCIAL</option>
                        <option value="ACHAT">ACHAT</option>
                        <option value="DIRECTION">DIRECTION</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg"
                        onclick="toggleModal('editUserModal')">Annuler</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white py-2 px-4 rounded-lg">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Modal Ajouter -->

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

    // Exemple d'ouverture du modal de modification
    function openEditModal(user) {
        console.log("User reçu :", user);

        // Remplir les champs du formulaire avec les données du user
        document.getElementById('editId').value = user.id || '';
        document.getElementById('editNom').value = user.nom || '';
        document.getElementById('editPrenom').value = user.prenom || '';
        document.getElementById('editEmail').value = user.email || '';
        document.getElementById('editRole').value = user.role || '';

        // Afficher le modal
        toggleModal('editUserModal');
    }

    // 3 points toggleDropdown
    function toggleDropdown(button) {
        const dropdown = button.nextElementSibling;
        dropdown.classList.toggle('hidden');
    }

    function filterTable() {
        const searchInput = document.getElementById('searchBar').value.toLowerCase();
        const table = document.getElementById('UserTable');
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
<script>
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