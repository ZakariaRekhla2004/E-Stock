<main class="p-6  min-h-screen">
    <div class="container mx-auto">
        <!-- Titre -->
        <h1 class="text-4xl font-bold mb-6 flex items-center space-x-3 text-[#003366]">
            <span>Tableau de Bord</span>
            <i class="fas fa-tachometer-alt text-[#0074D9] text-2xl"></i>
        </h1>

        <!-- Statistiques clés -->
        <div class="grid grid-cols-4 gap-6 mb-6">
            <!-- Total Catégories -->
            <div class="bg-[#F1F1F1] rounded-lg shadow-md p-4 flex flex-col items-center space-y-2">
                <div class="bg-[#0074D9] text-white w-12 h-12 flex justify-center items-center rounded-full">
                    <i class="fas fa-tags"></i>
                </div>
                <h2 class="text-lg font-semibold text-[#003366]">Total Catégories</h2>
                <p class="text-2xl font-bold text-[#0074D9]"><?= $nombreCategories ?></p>
            </div>

            <!-- Total Clients -->
            <div class="bg-[#F1F1F1] rounded-lg shadow-md p-4 flex flex-col items-center space-y-2">
                <div class="bg-[#0074D9] text-white w-12 h-12 flex justify-center items-center rounded-full">
                    <i class="fas fa-users"></i>
                </div>
                <h2 class="text-lg font-semibold text-[#003366]">Total Clients</h2>
                <p class="text-2xl font-bold text-[#0074D9]"><?= $nombreClients ?></p>
            </div>

            <!-- Total Commandes -->
            <div class="bg-[#F1F1F1] rounded-lg shadow-md p-4 flex flex-col items-center space-y-2">
                <div class="bg-[#FFC107] text-white w-12 h-12 flex justify-center items-center rounded-full">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h2 class="text-lg font-semibold text-[#003366]">Total Commandes</h2>
                <p class="text-2xl font-bold text-[#FFC107]"><?= $nombreCommandes ?></p>
            </div>

            <!-- Revenus Totaux -->
            <div class="bg-[#F1F1F1] rounded-lg shadow-md p-4 flex flex-col items-center space-y-2">
                <div class="bg-[#FFC107] text-white w-12 h-12 flex justify-center items-center rounded-full">
                    <i class="fas fa-euro-sign"></i>
                </div>
                <h2 class="text-lg font-semibold text-[#003366]">Revenus Totaux</h2>
                <p class="text-2xl font-bold text-[#FFC107]"><?= number_format($revenusTotaux, 2) ?> Mad</p>
            </div>
        </div>

        <!-- Tableaux -->
        <div class="grid grid-cols-2 gap-6 mb-6">
            <!-- Clients Actifs -->
            <div class="bg-white rounded-lg shadow-md p-4">
                <h3 class="text-lg font-semibold mb-4 text-[#003366]">Clients les Plus Actifs</h3>
                <table class="table-auto w-full border-collapse border rounded-lg">
                    <thead>
                        <tr class="bg-[#0074D9] text-white text-sm">
                            <th class="px-4 py-2 border">Nom</th>
                            <th class="px-4 py-2 border">Commandes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientsActifs as $client): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2 border"><?= htmlspecialchars($client['nom']) ?></td>
                            <td class="px-4 py-2 border"><?= $client['commandes'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Utilisateurs les Plus Actifs -->
            <div class="bg-white rounded-lg shadow-md p-4">
                <h3 class="text-lg font-semibold mb-4 text-[#003366]">Vendeurs les Plus Actifs</h3>
                <table class="table-auto w-full border-collapse border rounded-lg">
                    <thead>
                        <tr class="bg-[#FFC107] text-white text-sm">
                            <th class="px-4 py-2 border">Vendeur</th>
                            <th class="px-4 py-2 border">Commandes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($utilisateursActifs as $user): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2 border"> <?= htmlspecialchars($user['nom']) ?> <?= htmlspecialchars($user['prenom']) ?></td>
                            <td class="px-4 py-2 border"><?= $user['commandes'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="grid grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow-md p-4">
                <h3 class="text-lg font-semibold mb-4 text-[#003366]">Produits par Catégorie</h3>
                <canvas id="produitsParCategorieChart"></canvas>
            </div>
            <div class="bg-white rounded-lg shadow-md p-4">
                <h3 class="text-lg font-semibold mb-4 text-[#003366]">Ventes par Mois</h3>
                <canvas id="ventesParMoisChart"></canvas>
            </div>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Produits par Catégorie
    const produitsCategorieData = <?= json_encode($produitsParCategorie) ?>;
    const categoriesLabels = produitsCategorieData.map(item => item.nom);
    const produitsCounts = produitsCategorieData.map(item => item.total);

    new Chart(document.getElementById('produitsParCategorieChart'), {
        type: 'doughnut',
        data: {
            labels: categoriesLabels,
            datasets: [{
                data: produitsCounts,
                backgroundColor: ['#1E90FF', '#32CD32', '#FFA500', '#FF6347']
            }]
        }
    });

    // Ventes par Mois
    const ventesMoisData = <?= json_encode($ventesParMois) ?>;
    const moisLabels = ventesMoisData.map(item => item.mois);
    const ventesTotals = ventesMoisData.map(item => item.total);

    new Chart(document.getElementById('ventesParMoisChart'), {
        type: 'line',
        data: {
            labels: moisLabels,
            datasets: [{
                label: 'Ventes (Mad)',
                data: ventesTotals,
                borderColor: '#4CAF50',
                tension: 0.4
            }]
        }
    });
</script>
