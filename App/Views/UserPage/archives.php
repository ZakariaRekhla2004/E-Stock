<main class="p-6">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Archives des Utilisateurs</h1>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="table-auto w-full border-collapse border">
                <thead>
                    <tr class="bg-red-600 text-white uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left border">ID</th>
                        <th class="py-3 px-6 text-left border">Nom</th>
                        <th class="py-3 px-6 text-left border">Prénom</th>
                        <th class="py-3 px-6 text-left border">Email</th>
                        <th class="py-3 px-6 text-center border">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm font-medium">
                    <?php foreach ($deletedUsers as $user): ?>
                    <tr class="hover:bg-gray-100 transition-colors duration-200">
                        <td class="py-3 px-6 border"><?= htmlspecialchars($user['user_id']) ?></td>
                        <td class="py-3 px-6 border"><?= htmlspecialchars($user['nom']) ?></td>
                        <td class="py-3 px-6 border"><?= htmlspecialchars($user['prenom']) ?></td>
                        <td class="py-3 px-6 border"><?= htmlspecialchars($user['email']) ?></td>
                        <td class="py-3 px-6 text-center border">
                            <form method="POST" action="/user/restore" onsubmit="return confirmRestore(this);">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($user['user_id']) ?>">
                                <button type="submit" class="bg-green-600 hover:bg-green-500 text-white py-2 px-4 rounded-lg">
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
            text: "L'utilisateur sera restauré.",
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
</script>
