<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Stock</title>
    <link rel="icon" type="image/png" href="/public/assets/images/logo.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/public/assets/css/main.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-50">

    <div id="app" class="min-h-screen font-sans">
        <!-- En-tête -->
        <header class="bg-[#eeeeee] text-[#003060] py-4 px-6 shadow-lg fixed top-0 left-0 w-full z-50">
            <div class="container mx-auto flex justify-between items-center">
                <div class="flex items-center">
                    <img src="/public/assets/images/logo.png" alt="Logo E-Stock" class="h-12 w-12 mr-3">
                    <h1 class="text-3xl text-[#003060] font-extrabold">E-Stock</h1>
                </div>
                <nav>
                    <ul class="flex space-x-6">
                        <li><a href="#accueil" class="hover:text-indigo-300 transition">Accueil</a></li>
                        <li><a href="#a-propos" class="hover:text-indigo-300 transition">À propos</a></li>
                        <li><a href="#entreprise" class="hover:text-indigo-300 transition">Entreprise</a></li>
                        <li><a href="#equipe" class="hover:text-indigo-300 transition">Équipe</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!-- Contenu principal -->
        <main class="mt-[5rem]">
            <!-- Section Héro -->
            <section id="accueil" class="py-20 bg-gradient-to-r from-[#68bbe3] to-[#0e86d4] text-center">
                <div class="container mx-auto px-4">
                    <h2 class="text-5xl font-bold text-white mb-6">Bienvenue sur E-Stock</h2>
                    <p class="text-lg text-[#dddddd] mb-8">
                        Simplifiez la gestion de votre inventaire grâce à notre plateforme e-commerce performante.
                    </p>
                    <a href="/login"
                        class="bg-[#003060] hover:bg-[#205080] text-white py-3 px-8 rounded-full shadow-lg transition-transform transform hover:scale-105">
                        Connexion
                    </a>
                </div>
            </section>

            <!-- Section À propos -->
            <section id="a-propos" class="py-20 bg-gray-50 flex flex-col md:flex-row items-center">
                <div class="container mx-auto px-4 text-center">
                    <h2 class="text-4xl font-bold text-gray-800 mb-6">À propos d'E-Stock</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        E-Stock est une plateforme e-commerce intuitive conçue pour simplifier la gestion de votre
                        inventaire et vos processus de vente. Avec des fonctionnalités puissantes et une interface
                        conviviale, nous aidons les entreprises de toutes tailles à rationaliser leurs opérations et à
                        développer leur présence en ligne.
                    </p>
                </div>
            </section>

            <!-- Section Entreprise -->
            <section id="entreprise" class="md:flex-row items-center py-20 bg-white">

                <h2 class="text-4xl text-center font-bold text-gray-800 mb-4">À propos de l'entreprise</h2>
                <div class="container mx-auto px-4 md:flex md:justify-center md:items-center">
                    <div class="text-center md:text-left md:mr-4"> <!-- Réduire la marge à droite -->
                        <!-- Réduire la marge sous le titre -->
                        <p class="text-lg text-gray-600 max-w-2xl">
                            E-Stock a été développé par F.H.L.R. Digitalize, une entreprise leader en développement de
                            logiciels spécialisés dans les outils innovants de gestion d'entreprise. Notre mission est
                            de fournir des solutions technologiques qui répondent aux besoins actuels des entreprises
                            tout en anticipant leurs besoins futurs.
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0 flex justify-center items-center md:ml-4">
                        <!-- Réduire la marge du logo -->
                        <img src="/public/assets/images/FHLR.png" alt="Logo de l'entreprise" class="h-48">
                    </div>
                </div>
            </section>



            <!-- Section Équipe -->
            <section id="team" class="py-20 bg-gray-50">
                <div class="container mx-auto px-4 text-center">
                    <h2 class="text-4xl font-bold text-gray-800 mb-6">Rencontrez l'équipe</h2>
                    <div class="grid md:grid-cols-4 gap-8">
                        <!-- FELLAH Hamza -->
                        <div class="bg-white rounded-lg shadow-md p-6 text-center">
                            <img src="public/assets/images/fellah.jpg" alt="FELLAH Hamza"
                                class="rounded-full h-24 w-24 mx-auto mb-4">
                            <h3 class="text-xl font-bold mb-2">FELLAH Hamza</h3>
                            <p class="text-gray-600">Fullstack Developer</p>
                            <div class="flex justify-center space-x-4 mt-4">
                                <a href="https://github.com/Fhamza03" target="_blank"
                                    class="text-gray-600 hover:text-gray-800">
                                    <i class="fab fa-github text-2xl"></i>
                                </a>
                                <a href="https://www.linkedin.com/in/hamza-fellah-62b850217" target="_blank"
                                    class="text-blue-600 hover:text-blue-800">
                                    <i class="fab fa-linkedin text-2xl"></i>
                                </a>
                            </div>
                        </div>

                        <!-- HADADIA Saad -->
                        <div class="bg-white rounded-lg shadow-md p-6 text-center">
                            <img src="public/assets/images/hadadia.jpg" alt="HADADIA Saad"
                                class="rounded-full h-24 w-24 mx-auto mb-4">
                            <h3 class="text-xl font-bold mb-2">HADADIA Saad</h3>
                            <p class="text-gray-600">Fullstack Developer</p>
                            <div class="flex justify-center space-x-4 mt-4">
                                <a href="https://github.com/SaadHadadia" target="_blank"
                                    class="text-gray-600 hover:text-gray-800">
                                    <i class="fab fa-github text-2xl"></i>
                                </a>
                                <a href="https://www.linkedin.com/in/saad-hadadia-2b1686275" target="_blank"
                                    class="text-blue-600 hover:text-blue-800">
                                    <i class="fab fa-linkedin text-2xl"></i>
                                </a>
                            </div>
                        </div>

                        <!-- LEMKHRBECH Yahya -->
                        <div class="bg-white rounded-lg shadow-md p-6 text-center">
                            <img src="public/assets/images/lemkharbech.jpg" alt="LEMKHRBECH Yahya"
                                class="rounded-full h-24 w-24 mx-auto mb-4">
                            <h3 class="text-xl font-bold mb-2">LEMKHRBECH Yahya</h3>
                            <p class="text-gray-600">Fullstack Developer</p>
                            <div class="flex justify-center space-x-4 mt-4">
                                <a href="https://github.com/yahyalem02" target="_blank"
                                    class="text-gray-600 hover:text-gray-800">
                                    <i class="fab fa-github text-2xl"></i>
                                </a>
                                <a href="https://www.linkedin.com/in/yahya-lemkharebech-5a25b0236" target="_blank"
                                    class="text-blue-600 hover:text-blue-800">
                                    <i class="fab fa-linkedin text-2xl"></i>
                                </a>
                            </div>
                        </div>

                        <!-- REKHLA Zakaria -->
                        <div class="bg-white rounded-lg shadow-md p-6 text-center">
                            <img src="public/assets/images/rekhla.jpg" alt="REKHLA Zakaria"
                                class="rounded-full h-24 w-24 mx-auto mb-4">
                            <h3 class="text-xl font-bold mb-2">REKHLA Zakaria</h3>
                            <p class="text-gray-600">Fullstack Developer</p>
                            <div class="flex justify-center space-x-4 mt-4">
                                <a href="https://github.com/ZakariaRekhla2004" target="_blank"
                                    class="text-gray-600 hover:text-gray-800">
                                    <i class="fab fa-github text-2xl"></i>
                                </a>
                                <a href="https://www.linkedin.com/in/zakaria-rekhla-2116a72a1" target="_blank"
                                    class="text-blue-600 hover:text-blue-800">
                                    <i class="fab fa-linkedin text-2xl"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>



            <!-- Section Fonctionnalités -->
            <section id="features" class="py-20 bg-gray-100 text-center">
                <div class="container mx-auto px-4">
                    <h2 class="text-4xl font-bold text-gray-800 mb-6">Pourquoi choisir E-Stock ?</h2>
                    <div class="grid md:grid-cols-3 gap-8">
                        <div class="bg-white rounded-lg p-6 shadow-lg">
                            <i class="fas fa-cogs text-indigo-500 text-4xl mb-4"></i>
                            <h3 class="text-2xl font-semibold text-indigo-500 mb-4">Gestion simplifiée</h3>
                            <p class="text-gray-600">Gérez facilement vos niveaux de stock et suivez les mouvements de
                                vos produits.</p>
                        </div>
                        <div class="bg-white rounded-lg p-6 shadow-lg">
                            <i class="fas fa-chart-line text-indigo-500 text-4xl mb-4"></i>
                            <h3 class="text-2xl font-semibold text-indigo-500 mb-4">Analyses puissantes</h3>
                            <p class="text-gray-600">Obtenez des insights précieux sur les tendances de vos ventes.</p>
                        </div>
                        <div class="bg-white rounded-lg p-6 shadow-lg">
                            <i class="fas fa-plug text-indigo-500 text-4xl mb-4"></i>
                            <h3 class="text-2xl font-semibold text-indigo-500 mb-4">Intégration fluide</h3>
                            <p class="text-gray-600">Intégrez E-Stock à vos systèmes existants.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Pied de page -->
        <footer class="bg-gray-800 text-white py-6 px-6">
            <div class="container mx-auto px-4 flex justify-between items-center">
                <p>&copy; 2024 E-Stock Tous droits réservés.</p>
                <div class="flex space-x-4">
                    <a href="https://github.com/ZakariaRekhla2004/E-Stock/" target="_blank"
                        class="hover:text-indigo-400 transition"><i class="fab fa-github text-3xl"></i></a>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>