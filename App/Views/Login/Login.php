<section class="flex flex-row min-h-screen bg-blue-50">
    <!-- Partie gauche : Formulaire de connexion -->
    <div class="w-1/2 flex flex-col justify-center items-center bg-white shadow-lg p-12">
    <div class="text-left mb-8">
    <!-- Logo -->
    <img src="/public/assets/images/logo.png" alt="E-Stock Logo" class="h-32 mb-6">
    <h1 class="text-3xl font-bold text-black-800">BIENVENUE DE NOUVEAU !</h1>
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
    <a href="#" class="text-md text-gray-500 hover:underline ml-auto font-poppins font-semibold">
        Mot de passe oublié?
    </a>
</div>


            <button type="submit"
                class="w-full text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200" style="background-color: #003060;">
                Se connecter
            </button>
        </form>
    </div>

    <!-- Partie droite : Illustration -->
    <div class="w-1/2 flex justify-center items-center" style="background-color: #68bbe3;">
    <img src="/public/assets/images/LoginImage.png" alt="Illustration"
        class="w-200 h-full object-cover rounded-lg">
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

<?php 
var_dump($_SESSION);