<main class="p-6">
   <div class="container mx-auto">
       <h1 class="text-3xl font-bold mb-6 text-gray-800 flex items-center space-x-2">
           <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16M4 12h16M4 20h16" />
           </svg>
           <span>Primes non Calculées</span>
       </h1>

       <div class="mb-4 flex items-center space-x-4">
            <div class="relative w-[30%]">
                <input 
                    type="text" 
                    id="searchInput" 
                    placeholder="Rechercher par nom ou année" 
                    class="w-full px-3 py-2 border rounded-md pl-10 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                <!-- Icone de recherche -->
                <svg 
                    xmlns="http://www.w3.org/2000/svg" 
                    class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-500" 
                    fill="none" 
                    viewBox="0 0 24 24" 
                    stroke="currentColor"
                >
                    <path 
                        stroke-linecap="round" 
                        stroke-linejoin="round" 
                        stroke-width="2" 
                        d="M11 4a7 7 0 011.405 13.834l3.674 3.675a1 1 0 01-1.415 1.414l-3.675-3.674A7 7 0 1111 4z"
                    />
                </svg>
            </div>
        </div>

       <div class="bg-white rounded-lg shadow-md overflow-hidden">
           <table id="commercialsTable" class="table-auto w-full border-collapse border">
               <thead>
                   <tr class="bg-blue-600 text-white uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left border">Nom du Client </th>
                        <th class="py-3 px-6 text-left border">Total Des achats</th>
                       <th class="py-3 px-6 text-left border">Année</th>
                       <th class="py-3 px-6 text-center border">Actions</th>
                   </tr>
               </thead>
               <tbody>
                   <?php foreach ($clients as $client): ?>
                   <tr class="border-b hover:bg-gray-100">
                       <td class="py-3 px-6 text-left"><?= htmlspecialchars($client['client_name']) ?></td>
                       <td class="py-3 px-6 text-left"><?= number_format($client['total_achats'], 2) ?> €</td>
                       <td class="py-3 px-6 text-left"><?= htmlspecialchars($client['year']) ?></td>
                      
                       <td class="py-3 px-6 text-center">
                       <button onclick="calculateRemise(<?= $client['client_id'] ?>,<?= $client['year'] ?>, <?= $client['total_achats'] ?>)" 
                       class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                               Calculer Remise
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
           const year = row.cells[2].textContent;
           
           if (commercialName.includes(searchValue) || year.includes(searchValue)) {
               row.style.display = '';
           } else {
               row.style.display = 'none';
           }
       }
   });
   function calculateRemise(client_id, year, total_achats) {
    const clientlName = event.target.closest('tr').cells[0].textContent;

    if (confirm(`Voulez-vous calculer la remise pour ${clientlName} pour l'année ${year} ?`)) {
        fetch('/WithoutRemise/calculate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                client_id: client_id,
                year: year,
                total_achats: total_achats
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
                alert(`Remise calculée: ${data.remise} €`);
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