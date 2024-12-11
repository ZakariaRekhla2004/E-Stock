<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Stock</title>
    <link rel="icon" type="image/png" href="/public/assets/images/logo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/public/assets/css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg">
            <!-- Logo -->
            <div class="p-6 border-b flex justify-center items-center">
                <img src="/public/assets/images/logo.png" alt="E-Stock Logo" class="h-20 mb-6">
            </div>

            <!-- Navigation -->
            <nav class="p-4">
                <div class="space-y-4">

                    <!-- Accueil -->
                    <a href="/"
                        class="nav-item flex items-center p-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        Accueil
                    </a>

                    <?php if (App\Config\Auth::hasRole([
                        App\Model\Enums\UserRoles::COMERCIAL->value,
                        App\Model\Enums\UserRoles::ADMIN->value,
                        App\Model\Enums\UserRoles::DIRECTION->value,
                    ])) { ?>

<<<<<<< HEAD
                        <div class="nav-group">
                            <button
                                class="nav-item w-full flex items-center justify-between p-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    Gestion du Prime
                                </div>
                                <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="submenu pl-11 space-y-2">
                                <a href="/Prime"
                                    class="block py-2 text-sm text-gray-600 hover:text-blue-600">Primes Calculées</a>
                                <a href="/WithoutPrime" class="block py-2 text-sm text-gray-600 hover:text-blue-600">Primes Non Calculées</a>
                            </div>
                        </div>
                        
                        <div class="nav-group">
                            <button
                                class="nav-item w-full flex items-center justify-between p-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    Gestion du Remise
                                </div>
                                <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="submenu pl-11 space-y-2">
                                <a href="/Remise"
                                    class="block py-2 text-sm text-gray-600 hover:text-blue-600">Remises Calculées</a>
                                <a href="/WithoutRemise" class="block py-2 text-sm text-gray-600 hover:text-blue-600">Remises Non Calculées</a>
                            </div>
                        </div>

                        <!-- Gestion du Stock -->
                        <div class="nav-group">
                            <button
                                class="nav-item w-full flex items-center justify-between p-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    Gestion du Stock
                                </div>
                                <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div class="submenu pl-11 space-y-2">
                                <a href="/Category"
                                    class="block py-2 text-sm text-gray-600 hover:text-blue-600">Catégories</a>
                                <a href="/Product" class="block py-2 text-sm text-gray-600 hover:text-blue-600">Produits</a>
                            </div>
                        </div>
=======
                    <!-- Client -->
                    <a href="/Client"
                        class="nav-item flex items-center p-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        Clients
                    </a>
                    <?php } ?>
>>>>>>> Bsaad

                    <?php if (App\Config\Auth::hasRole([
                        App\Model\Enums\UserRoles::RH->value,
                        App\Model\Enums\UserRoles::ADMIN->value,
                        App\Model\Enums\UserRoles::DIRECTION->value,
                    ])) { ?>
                    <!-- Personnel -->
                    <a href="/user"
                        class="nav-item flex items-center p-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        Personnel
                    </a>

                    <?php } ?>

                    <?php if (App\Config\Auth::hasRole([
                        App\Model\Enums\UserRoles::ACHAT->value,
                        App\Model\Enums\UserRoles::ADMIN->value,
                        App\Model\Enums\UserRoles::DIRECTION->value
                    ])) { ?>
                    <!-- Gestion du Stock -->
                    <div class="nav-group">
                        <button
                            class="nav-item w-full flex items-center justify-between p-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Gestion du Stock
                            </div>
                            <svg class="w-4 h-4 transition-transform" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="submenu pl-11 space-y-2">
                            <a href="/Category"
                                class="block py-2 text-sm text-gray-600 hover:text-blue-600">Catégories</a>
                            <a href="/Product" class="block py-2 text-sm text-gray-600 hover:text-blue-600">Produits</a>
                        </div>
                    </div>
                    <?php } ?>

                    <?php if (App\Config\Auth::hasRole([
                        App\Model\Enums\UserRoles::COMERCIAL->value,
                    ])) { ?>
                    <!-- Commandes -->
                    <a href="/Commande"
                        class="nav-item flex items-center p-2 text-gray-700 rounded-lg hover:bg-blue-50 hover:text-blue-600">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3M8 7a2 2 0 002-2V3m4 4a2 2 0 002-2V3M8 7h8">
                            </path>
                        </svg>
                        Commandes
                    </a>
                    <?php } ?>

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

                        <!-- Profile Dropdown -->
                        <div x-data="{ open: false }" class="relative inline-block text-left">
                            <div>
                                <button @click="open = !open" type="button"
                                    class="inline-flex items-center justify-center rounded-full border border-gray-300 bg-white p-0 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <!-- Profile Icon (Updated Male User) -->
                                    <svg class="h-6 w-6 text-gray-700" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>

                            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95" @click.outside="open = false"
                                class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                role="menu">
                                <div class="py-1">
                                    <a href="my-profile"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                        <!-- Profile Menu Icon (Updated Male User) -->
                                        <svg class="h-5 w-5 text-gray-600 mr-2" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Mon Profile
                                    </a>
                                    <a href="/logout"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                        <!-- Logout Icon (Clear Exit Style) -->
                                        <svg class="h-5 w-5 text-gray-600 mr-2" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12"></line>
                                        </svg>
                                        Se Déconnecter
                                    </a>
                                </div>
                            </div>
                        </div>




                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="p-6">
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

<?php if (isset($_SESSION['success_message'])): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Succès',
        text: <?= json_encode($_SESSION['success_message']) ?>
    });
</script>
<?php unset($_SESSION['success_message']); endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Erreur',
        text: <?= json_encode($_SESSION['error_message']) ?>
    });
</script>
<?php unset($_SESSION['error_message']); endif; ?>


</body>