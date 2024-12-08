<main class="p-6 bg-gray-50">
    <!-- Categories -->
    <div class="flex space-x-4 mb-6 overflow-x-auto scrollbar-hide">
        <button class="category-tab no-rounded bg-blue-500 text-white px-4 py-2 hover:bg-blue-600" data-category="electronique">Électronique</button>
        <button class="category-tab no-rounded bg-gray-200 text-gray-700 px-4 py-2 hover:bg-gray-300" data-category="textile">Textile</button>
        <button class="category-tab no-rounded bg-gray-200 text-gray-700 px-4 py-2 hover:bg-gray-300" data-category="bricolage">Bricolage</button>
        <button class="category-tab no-rounded bg-gray-200 text-gray-700 px-4 py-2 hover:bg-gray-300" data-category="animalerie">Animalerie</button>
        <button class="category-tab no-rounded bg-gray-200 text-gray-700 px-4 py-2 hover:bg-gray-300" data-category="jouets">Jouets</button>
    </div>

    <!-- Products -->
    <div id="product-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <!-- Products will be dynamically rendered here -->
    </div>

    <!-- Cart Icon -->
    <button id="cart-icon" class="fixed bottom-6 right-6 bg-blue-500 text-white p-4 rounded-full shadow-lg hover:bg-blue-600">
        <i class="fas fa-shopping-cart text-xl"></i>
        <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-semibold w-6 h-6 flex items-center justify-center rounded-full">0</span>
    </button>

    <!-- Cart -->
    <aside id="cart" class="fixed top-0 right-0 w-80 bg-white h-full shadow-lg p-6 transform translate-x-full">
        <h2 class="text-xl font-semibold mb-4">Panier</h2>
        <ul id="cart-list" class="space-y-4">
            <!-- Cart items will be dynamically rendered here -->
        </ul>
        <button id="close-cart" class="w-full mt-6 bg-red-500 text-white px-4 py-2 no-rounded hover:bg-red-600">Fermer le panier</button>
    </aside>

    <!-- Modal -->
    <div id="product-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white w-96 p-6 shadow-lg relative">
            <button id="close-modal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>
            <img id="modal-image" src="" alt="" class="w-full h-48 object-cover mb-4">
            <h3 id="modal-title" class="text-lg font-semibold"></h3>
            <p id="modal-description" class="text-gray-600 my-4"></p>
            <div class="flex items-center justify-between mt-4">
                <input type="number" id="modal-quantity" class="border px-3 py-1 w-16 no-rounded text-center" min="1" value="1">
                <button id="modal-add-to-cart" class="bg-blue-500 text-white px-4 py-2 no-rounded hover:bg-blue-600">Ajouter au panier</button>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const products = [
        { id: 1, name: 'PC Gamer MZL MLIH', price: 9999, image: 'https://via.placeholder.com/300', category: 'electronique' },
        { id: 2, name: 'PC Portable', price: 8999, image: 'https://via.placeholder.com/300', category: 'electronique' },
        { id: 3, name: 'Souris Gamer', price: 800, image: 'https://via.placeholder.com/300', category: 'electronique' },
        { id: 4, name: 'Casque Gamer', price: 900, image: 'https://via.placeholder.com/300', category: 'electronique' },
        { id: 7, name: 'T-Shirt Moderne', price: 300, image: 'https://via.placeholder.com/300', category: 'textile' },
        { id: 8, name: 'Jouet Robot', price: 1200, image: 'https://via.placeholder.com/300', category: 'jouets' },
    ];

    let cart = [];

    // Render products
    function renderProducts(category = null) {
        const productContainer = document.getElementById('product-container');
        productContainer.innerHTML = '';
        const filteredProducts = category ? products.filter(p => p.category === category) : products;

        filteredProducts.forEach(product => {
            const productCard = `
                <div class="border no-rounded p-4 hover:shadow-lg transition relative">
                    <img src="${product.image}" alt="${product.name}" class="w-full h-32 object-cover mb-4">
                    <h3 class="text-lg font-semibold">${product.name}</h3>
                    <p class="text-gray-600">${product.price} DH</p>
                    <div class="flex justify-between items-center mt-4">
                        <button class="view-details bg-gray-200 px-4 py-2 no-rounded" data-id="${product.id}">Voir aperçu</button>
                        <button class="add-to-cart bg-blue-500 text-white px-4 py-2 no-rounded" data-id="${product.id}">Ajouter</button>
                    </div>
                </div>
            `;
            productContainer.insertAdjacentHTML('beforeend', productCard);
        });
    }

    // Update cart
    function updateCart() {
        const cartList = document.getElementById('cart-list');
        const cartCount = document.getElementById('cart-count');
        cartList.innerHTML = '';

        if (cart.length === 0) {
            cartList.innerHTML = '<li class="text-gray-500">Votre panier est vide.</li>';
        } else {
            cart.forEach(item => {
                const cartItem = `
                    <li class="flex justify-between items-center">
                        <div>${item.name} (x${item.quantity})</div>
                        <div>${item.price * item.quantity} DH</div>
                    </li>
                `;
                cartList.insertAdjacentHTML('beforeend', cartItem);
            });
        }

        cartCount.textContent = cart.reduce((acc, item) => acc + item.quantity, 0);
    }

    // Add to cart
    function addToCart(productId, quantity) {
        const product = products.find(p => p.id === productId);
        const existing = cart.find(item => item.id === productId);

        if (existing) {
            existing.quantity += quantity;
        } else {
            cart.push({ ...product, quantity });
        }

        updateCart();
    }

    // Event listeners
    document.querySelectorAll('.category-tab').forEach(button => {
        button.addEventListener('click', () => {
            renderProducts(button.dataset.category);
        });
    });

    document.getElementById('product-container').addEventListener('click', e => {
        if (e.target.classList.contains('add-to-cart')) {
            const productId = parseInt(e.target.dataset.id);
            addToCart(productId, 1);
        } else if (e.target.classList.contains('view-details')) {
            const productId = parseInt(e.target.dataset.id);
            const product = products.find(p => p.id === productId);

            document.getElementById('modal-image').src = product.image;
            document.getElementById('modal-title').textContent = product.name;
            document.getElementById('modal-description').textContent = product.description;
            document.getElementById('modal-add-to-cart').dataset.id = productId;
            document.getElementById('product-modal').classList.remove('hidden');
        }
    });

    document.getElementById('modal-add-to-cart').addEventListener('click', () => {
        const productId = parseInt(document.getElementById('modal-add-to-cart').dataset.id);
        const quantity = parseInt(document.getElementById('modal-quantity').value);
        addToCart(productId, quantity);
        document.getElementById('product-modal').classList.add('hidden');
    });

    document.getElementById('close-modal').addEventListener('click', () => {
        document.getElementById('product-modal').classList.add('hidden');
    });

    document.getElementById('cart-icon').addEventListener('click', () => {
        document.getElementById('cart').classList.remove('translate-x-full');
    });

    document.getElementById('close-cart').addEventListener('click', () => {
        document.getElementById('cart').classList.add('translate-x-full');
    });

    // Initialize
    renderProducts();
    updateCart();
});
</script>
