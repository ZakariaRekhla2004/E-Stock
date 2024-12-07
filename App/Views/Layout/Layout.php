<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Stock - Système de Gestion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/public/assets/css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</head>

<body class="bg-gray-50">
<div class="min-h-screen flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg">
        <!-- Logo -->
        <div class="p-6 border-b flex justify-center items-center">
            <img src="../../../public/assets/images/logo.png" alt="e-Stock" class="h-16 w-16">
        </div>

        <!-- Navigation -->
        <nav class="p-4">
            <div class="space-y-4">
                <!-- Accueil -->
                <a href="#" class="nav-item flex items-center p-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Accueil
                </a>

                <!-- Gestion des clients -->
                <div class="nav-group">
                    <button class="nav-item w-full flex items-center justify-between p-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            Gestion des clients
                        </div>
                        <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="submenu pl-11 space-y-2">
                        <a href="#" class="block py-2 text-sm text-gray-600 hover:text-blue-600">Ajouter client</a>
                        <a href="#" class="block py-2 text-sm text-gray-600 hover:text-blue-600">Liste des clients</a>
                    </div>
                </div>

                <!-- Gestion du stock -->
                <div class="nav-group">
                    <button class="nav-item w-full flex items-center justify-between p-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Gestion du stock
                        </div>
                        <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="submenu pl-11 space-y-2">
                        <a href="#" class="block py-2 text-sm text-gray-600 hover:text-blue-600">Catégories</a>
                        <a href="#" class="block py-2 text-sm text-gray-600 hover:text-blue-600">Produits</a>
                    </div>
                </div>

                <!-- Other menu items... -->
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1" style="background-color: #f5fcff;">
        <!-- Top Navigation -->
        <header class="bg-white shadow-sm">
            <div class="flex justify-between items-center px-6 py-4">
                <h1 class="text-xl font-semibold text-gray-800">ACCUEIL</h1>
                <div class="flex items-center space-x-4">
                    <a href="#" class="text-gray-600 hover:text-blue-600">E-STOCK</a>
                    <a href="#" class="text-gray-600 hover:text-blue-600">ACCUEIL</a>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="p-6">
            <!-- PHP content will be injected here -->
        <div class="container">
            <?php include htmlspecialchars($view); ?>
        </div>    
        </main>
    </div>
</div>

<script>
    // Gestion des sous-menus
    document.querySelectorAll('.nav-group').forEach(group => {
        const button = group.querySelector('button');
        const submenu = group.querySelector('.submenu');
        const arrow = button.querySelector('svg:last-child');

        button.addEventListener('click', () => {
            submenu.classList.toggle('active');
            arrow.style.transform = submenu.classList.contains('active') ? 'rotate(180deg)' : '';
        });
    });
</script>

</body>
