<section class="flex flex-col md:flex-row min-h-screen bg-blue-50">
    <!-- Partie gauche : Formulaire de connexion -->
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center bg-white shadow-lg px-6 py-12 md:p-12">
        <div class="text-center md:text-left mb-6">
            <!-- Logo -->
            <img src="/public/assets/images/logo.png" alt="E-Stock Logo" class="h-16 md:h-24 mb-4">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">BIENVENUE DE NOUVEAU !</h1>
            <p class="text-gray-600">Veuillez entrer vos identifiants ci-dessous</p>
        </div>

        <!-- Formulaire -->
        <form action="login" method="POST" class="w-full max-w-sm">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" placeholder="Entrer votre email"
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="******************"
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    required>
            </div>
            <div class="flex justify-between items-center mb-6">
                <!-- Optional space for additional controls -->
            </div>

            <button type="submit"
                class="w-full text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200" style="background-color: #003060;">
                Se connecter
            </button>
        </form>

        <!-- Bouton Retour -->
        <a href="/" class="mt-4 inline-block text-center text-white py-2 px-6 rounded-md shadow-md hover:bg-blue-600 transition duration-200" style="background-color: #68bbe3;">
            Retour à l'accueil
        </a>
    </div>

    <!-- Partie droite : Illustration (Hidden on small screens) -->
    <div class="hidden md:flex w-full md:w-1/2 justify-center items-center" style="background-color: #68bbe3;">
        <img src="/public/assets/images/LoginImage.png" alt="Illustration"
            class="w-full md:w-auto h-64 md:h-full object-cover rounded-lg">
    </div>
</section>
<script>
    <?php if (!empty($_SESSION['error_message'])): ?>
    Swal.fire({
        icon: 'error',
        title: 'Erreur',
        text: '<?= addslashes($_SESSION['error_message']) ?>',
    });
    <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
</script>