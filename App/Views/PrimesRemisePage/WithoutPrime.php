<main class="p-6">
   <div class="container mx-auto">
       <h1 class="text-3xl font-bold mb-6 text-gray-800 flex items-center space-x-2">
           <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16M4 12h16M4 20h16" />
           </svg>
           <span>Primes non Calculées</span>
       </h1>

       <div class="mb-4 flex items-center space-x-4">
           <input 
               type="text" 
               id="searchInput" 
               placeholder="Rechercher par nom ou année" 
               class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
           >
       </div>

       <div class="bg-white rounded-lg shadow-md overflow-hidden">
           <table id="commercialsTable" class="table-auto w-full border-collapse border">
               <thead>
                   <tr class="bg-blue-600 text-white uppercase text-sm leading-normal">
                       <th class="py-3 px-6 text-left border">Nom du Commercial</th>
                       <th class="py-3 px-6 text-left border">Année</th>
                       <th class="py-3 px-6 text-left border">Chiffre d'Affaire</th>
                       <th class="py-3 px-6 text-center border">Actions</th>
                   </tr>
               </thead>
               <tbody>
                   <?php foreach ($commercials as $commercial): ?>
                   <tr class="border-b hover:bg-gray-100">
                       <td class="py-3 px-6 text-left"><?= htmlspecialchars($commercial['commercial_name']) ?></td>
                       <td class="py-3 px-6 text-left"><?= htmlspecialchars($commercial['year']) ?></td>
                       <td class="py-3 px-6 text-left"><?= number_format($commercial['chiffre_affaire'], 2) ?> €</td>
                       <td class="py-3 px-6 text-center">
                       <button onclick="calculatePrime(<?= $commercial['commercial_id'] ?>,<?= $commercial['year'] ?>, <?= $commercial['chiffre_affaire'] ?>)" 
                       class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                               Calculer Prime
                           </button>
                       </td>
                   </tr>
                   <?php endforeach; ?>
               </tbody>
           </table>
       </div>
   </div>

   <script>
   document.getElementById('searchInput').addEventListener('keyup', function() {
       const searchValue = this.value.toLowerCase();
       const table = document.getElementById('commercialsTable');
       const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

       for (let row of rows) {
           const commercialName = row.cells[0].textContent.toLowerCase();
           const year = row.cells[1].textContent;
           
           if (commercialName.includes(searchValue) || year.includes(searchValue)) {
               row.style.display = '';
           } else {
               row.style.display = 'none';
           }
       }
   });

   function calculatePrime(commercialId, year, chiffreAffaire) {
    const commercialName = event.target.closest('tr').cells[0].textContent;

    if (confirm(`Voulez-vous calculer la prime pour ${commercialName} pour l'année ${year} ?`)) {
        fetch('/WithoutPrime/calculate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                commercialId: commercialId,
                year: year,
                chiffreAffaire: chiffreAffaire
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert(`Prime calculée: ${data.prime} €`);
                location.reload();
            } else {
                alert(data.message || 'Erreur lors du calcul de la prime');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue');
        });
    }
}</script>
</main>