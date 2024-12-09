<main class="p-6 bg-gray-50">
    <!-- Categories -->
    <div id="categories-container" class="flex space-x-4 mb-6 overflow-x-auto scrollbar-hide"></div>

    <!-- Products -->
    <div id="product-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"></div>

    <!-- Cart Icon -->
    <button id="cart-icon"
        class="fixed bottom-6 right-6 bg-blue-500 text-white p-4 rounded-full shadow-lg hover:bg-blue-600">
        <i class="fas fa-shopping-cart text-xl"></i>
        <span id="cart-count"
            class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-semibold w-6 h-6 flex items-center justify-center rounded-full">0</span>
    </button>

    <!-- Cart -->
    <aside id="cart" class="fixed top-0 right-0 w-80 bg-white h-full shadow-lg p-6 transform translate-x-full">
        <h2 class="text-xl font-semibold mb-4">Panier</h2>
        <div class="mb-4">
            <label for="client-select" class="block text-sm font-medium text-gray-700">Sélectionner un client :</label>
            <select id="client-select" class="border w-full px-3 py-2 rounded">
                <option value="">Chargement des clients...</option>
            </select>
        </div>
        <input type="hidden" id="user-id" value="1">
        <ul id="cart-list" class="space-y-4"></ul>
        <div class="mt-4 text-lg font-semibold">
            Total: <span id="cart-total">0</span> DH
        </div>
        <button id="print-invoice"
            class="w-full mt-2 bg-green-500 text-white px-4 py-2 no-rounded hover:bg-green-600">Imprimer la
            facture</button>

        <button id="confirm-order"
            class="w-full mt-6 bg-blue-500 text-white px-4 py-2 no-rounded hover:bg-blue-600">Confirmer la
            commande</button>
        <button id="close-cart" class="w-full mt-2 bg-red-500 text-white px-4 py-2 no-rounded hover:bg-red-600">Fermer
            le panier</button>
    </aside>

    <!-- Modal -->
    <div id="product-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white w-96 p-6 shadow-lg relative">
            <button id="close-modal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>
            <img id="modal-image" src="" alt="" class="w-full h-48 object-cover mb-4">
            <h3 id="modal-title" class="text-lg font-semibold"></h3>
            <p id="modal-description" class="text-gray-600 my-4"></p>
            <div class="flex items-center justify-between mt-4">
                <input type="number" id="modal-quantity" class="border px-3 py-1 w-16 no-rounded text-center"
                    min="1" value="1">
                <button id="modal-add-to-cart"
                    class="bg-blue-500 text-white px-4 py-2 no-rounded hover:bg-blue-600">Ajouter au panier</button>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        let products = [];
        let cart = [];
        const categoriesContainer = document.getElementById('categories-container');
        const productContainer = document.getElementById('product-container');
        const cartList = document.getElementById('cart-list');
        const clientSelect = document.getElementById('client-select');
        const userIdField = document.getElementById('user-id');
        const cartCount = document.getElementById('cart-count');

        function loadCategories() {
            fetch('/categoriesPanier')
                .then(response => response.json())
                .then(categories => {
                    categoriesContainer.innerHTML = '';
                    categories.forEach(category => {
                        const button = document.createElement('button');
                        button.className =
                            "category-tab no-rounded bg-gray-200 text-gray-700 px-4 py-2 hover:bg-gray-300";
                        button.dataset.category = category.id;
                        button.textContent = category.nom;
                        button.addEventListener('click', () => renderProducts(category.id));
                        categoriesContainer.appendChild(button);
                    });
                })
                .catch(error => console.error('Erreur lors du chargement des catégories:', error));
        }

        function loadProducts() {
            fetch('/productsPanier')
                .then(response => response.json())
                .then(data => {
                    products = data;
                    renderProducts();
                })
                .catch(error => console.error('Erreur lors du chargement des produits:', error));
        }

        function loadClients() {
            fetch('/clientPanier')
                .then(response => response.json())
                .then(clients => {
                    clientSelect.innerHTML = '<option value="">Sélectionner un client</option>';
                    clients.forEach(client => {
                        const option = document.createElement('option');
                        option.value = client.id;
                        option.textContent = `${client.nom} ${client.prenom}`;
                        clientSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Erreur lors du chargement des clients:', error));
        }

        function renderProducts(categoryId = null) {
            productContainer.innerHTML = '';
            const filteredProducts = categoryId ? products.filter(p => p.idCategorie === categoryId) : products;

            filteredProducts.forEach(product => {
                const productCard = `
                <div class="border no-rounded p-4 hover:shadow-lg transition relative">
                    <img src="${product.pathImage}" alt="${product.designation}" class="w-full h-32 object-cover mb-4">
                    <h3 class="text-lg font-semibold">${product.designation}</h3>
                    <p class="text-gray-600">${product.prix} DH</p>
                    <p class="text-sm text-gray-500">Stock disponible: ${product.qtt}</p>
                    <div class="flex justify-between items-center mt-4">
                        <button class="view-details bg-gray-200 px-4 py-2 no-rounded" data-id="${product.id}">Voir aperçu</button>
                        <button class="add-to-cart bg-blue-500 text-white px-4 py-2 no-rounded" data-id="${product.id}">Ajouter</button>
                    </div>
                </div>
            `;
                productContainer.insertAdjacentHTML('beforeend', productCard);
            });

            productContainer.addEventListener('click', (event) => {
                if (event.target.classList.contains('add-to-cart')) {
                    const productId = parseInt(event.target.dataset.id, 10);
                    addToCart(productId, 1);
                } else if (event.target.classList.contains('view-details')) {
                    const productId = parseInt(event.target.dataset.id, 10);
                    const product = products.find(p => p.id === productId);
                    document.getElementById('modal-image').src = product.pathImage;
                    document.getElementById('modal-title').textContent = product.designation;
                    document.getElementById('modal-description').textContent =
                        `Prix: ${product.prix} DH`;
                    document.getElementById('modal-quantity').value = 1;
                    document.getElementById('modal-add-to-cart').dataset.id = productId;
                    document.getElementById('product-modal').classList.remove('hidden');
                }
            });
        }

        function addToCart(productId, quantity) {
            const product = products.find(p => p.id === productId);
            const existing = cart.find(item => item.id === productId);

            if (existing) {
                const newQuantity = existing.quantity + quantity;
                if (newQuantity > product.qtt) {
                    alert(`Quantité demandée dépasse le stock disponible (${product.qtt} unités).`);
                    return;
                }
                existing.quantity = newQuantity;
            } else {
                if (quantity > product.qtt) {
                    alert(`Quantité demandée dépasse le stock disponible (${product.qtt} unités).`);
                    return;
                }
                cart.push({
                    ...product,
                    quantity
                });
            }
            updateCart();
        }

        function updateCart() {
            cartList.innerHTML = '';
            if (cart.length === 0) {
                cartList.innerHTML = '<li class="text-gray-500">Votre panier est vide.</li>';
            } else {
                cart.forEach(item => {
                    const cartItem = `
                    <li class="flex justify-between items-center">
                        <div>${item.designation}</div>
                        <input type="number" min="1" max="${item.qtt}" class="quantity-input border w-16 text-center" data-id="${item.id}" value="${item.quantity}">
                        <div>${item.prix * item.quantity} DH</div>
                    </li>
                `;
                    cartList.insertAdjacentHTML('beforeend', cartItem);
                });
            }

            cartList.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', (event) => {
                    const productId = parseInt(event.target.dataset.id, 10);
                    const newQuantity = parseInt(event.target.value, 10);
                    if (newQuantity <= 0 || isNaN(newQuantity)) {
                        alert('La quantité doit être un nombre positif.');
                        event.target.value = cart.find(item => item.id === productId).quantity;
                        return;
                    }
                    updateQuantity(productId, newQuantity);
                });
            });

            cartCount.textContent = cart.reduce((acc, item) => acc + item.quantity, 0);
            const total = cart.reduce((acc, item) => acc + item.prix * item.quantity, 0);
            document.getElementById('cart-total').textContent = total.toFixed(2);

        }

        function updateQuantity(productId, newQuantity) {
            const product = cart.find(item => item.id === productId);
            const stockProduct = products.find(p => p.id === productId);

            if (product) {
                if (newQuantity > stockProduct.qtt) {
                    alert(`Quantité demandée dépasse le stock disponible (${stockProduct.qtt} unités).`);
                    return;
                }
                product.quantity = newQuantity;
                updateCart();
            }
        }

        function printInvoice() {
    const clientId = clientSelect.value;
    if (!clientId) {
        alert('Veuillez sélectionner un client avant d\'imprimer la facture.');
        return;
    }

    const clientName = clientSelect.options[clientSelect.selectedIndex].text;

    let invoiceWindow = window.open('', '_blank');
    invoiceWindow.document.write(`
        <html>
            <head>
                <title>Facture</title>
                <style>
                    body { font-family: Arial, sans-serif; margin: 20px; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f4f4f4; }
                </style>
            </head>
            <body>
                <h1>Facture</h1>
                <p><strong>No. Client:</strong> ${clientId}</p>
                <p><strong>Nom Client:</strong> ${clientName}</p>
                <table>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix Unitaire (DH)</th>
                        <th>Total (DH)</th>
                    </tr>
                    ${cart.map(item => `
                        <tr>
                            <td>${item.designation}</td>
                            <td>${item.quantity}</td>
                            <td>${item.prix}</td>
                            <td>${(item.prix * item.quantity).toFixed(2)}</td>
                        </tr>
                    `).join('')}
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                        <td><strong>${cart.reduce((acc, item) => acc + item.prix * item.quantity, 0).toFixed(2)} DH</strong></td>
                    </tr>
                </table>
            </body>
        </html>
    `);
    invoiceWindow.document.close();
    invoiceWindow.print();
}


        document.getElementById('cart-icon').addEventListener('click', () => {
            document.querySelector('aside#cart').classList.remove('translate-x-full');
        });
        document.getElementById('close-cart').addEventListener('click', () => {
            document.querySelector('aside#cart').classList.add('translate-x-full');
        });
        document.getElementById('confirm-order').addEventListener('click', () => {
            const clientId = clientSelect.value;
            const userId = userIdField.value;
            if (!clientId) {
                alert('Veuillez sélectionner un client.');
                return;
            }
            if (cart.length === 0) {
                alert('Votre panier est vide.');
                return;
            }
            const orderData = {
                idClient: parseInt(clientId, 10),
                idUser: parseInt(userId, 10),
                products: cart.map(item => ({
                    idProduit: item.id,
                    quantity: item.quantity
                }))
            };
            fetch('/Commande/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(orderData)
                })
                .then(response => response.json())
                .then(data => {
                    alert('Commande confirmée avec succès.');
                    cart = [];
                    updateCart();
                    clientSelect.value = '';
                })
                .catch(error => console.error('Erreur lors de la confirmation de la commande:', error));
        });

        document.getElementById('modal-add-to-cart').addEventListener('click', () => {
            const productId = parseInt(document.getElementById('modal-add-to-cart').dataset.id, 10);
            const quantity = parseInt(document.getElementById('modal-quantity').value, 10);
            addToCart(productId, quantity);
            document.getElementById('product-modal').classList.add('hidden');
        });

        document.getElementById('close-modal').addEventListener('click', () => {
            document.getElementById('product-modal').classList.add('hidden');
        });
        document.getElementById('print-invoice').addEventListener('click', printInvoice);


        loadCategories();
        loadProducts();
        loadClients();
    });
</script>
