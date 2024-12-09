<head>
    <!-- Ajouter le CDN de Font Awesome dans le head -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<main class="p-6 bg-gray-50 min-h-screen">

    <form action="/my-profile/update" method="POST">
        <div class="flex flex-col sm:flex-row gap-6">
            <!-- Nom -->
            <div class="flex-1">
                <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                <div class="mt-2">
                    <input type="text" name="nom" id="nom" value="<?php echo $user['nom']; ?>"
                        class="input-style" required disabled>
                </div>
            </div>

            <!-- Prénom -->
            <div class="flex-1">
                <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                <div class="mt-2">
                    <input type="text" name="prenom" id="prenom" value="<?php echo $user['prenom']; ?>"
                        class="input-style" required disabled>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-6 mt-6">
            <!-- Email -->
            <div class="flex-1">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <div class="mt-2">
                    <input type="email" name="email" id="email" value="<?php echo $user['email']; ?>"
                        class="input-style" required disabled>
                </div>
            </div>

            <!-- Mot de passe -->
            <div class="flex-1 relative">
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <div class="mt-2 relative">
                    <input type="password" name="password" id="password" value="********"
                        class="input-style" required disabled>
                    <button type="button" id="togglePasswordBtn" class="absolute inset-y-0 right-2 flex items-center justify-center text-gray-500 hover:text-gray-700 focus:outline-none hidden">
                        <i class="fas fa-eye w-5 h-5"></i> <!-- Icône d'œil de Font Awesome -->
                    </button>
                </div>
                <!-- Indicateur de la force du mot de passe -->
                <div id="passwordStrength" class="mt-1 text-sm"></div>
            </div>
        </div>

        <!-- Boutons pour sauvegarder et annuler -->
        <div id="actions" class="mt-6 flex justify-center gap-4 hidden">
            <button id="sauvegarderBtn" type="submit"
                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none">
                Sauvegarder les modifications
            </button>
            <button id="annulerBtn" type="button"
                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-400 focus:outline-none">
                Annuler
            </button>
        </div>
    </form>

    <!-- Bouton pour activer le mode édition -->
    <div class="mt-6 flex justify-center">
        <button id="modifierProfileBtn" type="button"
            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none">
            Modifier mon profil
        </button>
    </div>

</main>

<style>
    .input-style {
        display: block;
        width: 100%;
        padding: 8px;
        border: 1px solid #d1d5db; /* Gris faible pour disabled */
        border-radius: 4px;
        background-color: transparent;
        color: #374151;
        font-size: 0.875rem;
        transition: border-color 0.3s;
    }

    .input-style:enabled {
        border-color: #3b82f6; /* Bleu pour enabled */
    }

    .input-style:focus {
        outline: none;
        border-color: #2563eb; /* Bleu fort pour focus */
        box-shadow: 0 0 0 1px #2563eb;
    }

    /* Positionnement du bouton pour l'icône */
    .relative {
        position: relative;
    }

    #togglePasswordBtn {
        cursor: pointer;
    }

    /* Cacher l'icône par défaut */
    #togglePasswordBtn.hidden {
        display: none;
    }

    #passwordStrength {
        font-size: 0.875rem;
        font-weight: bold;
    }

    /* Styles pour l'indicateur de force du mot de passe */
    .weak {
        color: red;
    }

    .medium {
        color: orange;
    }

    .strong {
        color: green;
    }
</style>

<script>
    const modifierBtn = document.getElementById('modifierProfileBtn');
    const sauvegarderBtn = document.getElementById('sauvegarderBtn');
    const annulerBtn = document.getElementById('annulerBtn');
    const inputs = document.querySelectorAll('.input-style');
    const actionsDiv = document.getElementById('actions');
    const passwordInput = document.getElementById('password');
    const togglePasswordBtn = document.getElementById('togglePasswordBtn');
    const passwordStrength = document.getElementById('passwordStrength');

    // Stocker les valeurs initiales, y compris le mot de passe
    const initialValues = {
        nom: document.getElementById('nom').value,
        prenom: document.getElementById('prenom').value,
        email: document.getElementById('email').value,
        password: '********' // Valeur initiale du mot de passe
    };

    // Activer le mode édition
    modifierBtn.addEventListener('click', function () {
        inputs.forEach(input => {
            input.disabled = false;
        });
        // Vider le mot de passe
        passwordInput.value = '';
        togglePasswordBtn.classList.remove('hidden'); // Afficher l'icône d'œil
        modifierBtn.classList.add('hidden'); // Masquer le bouton "Modifier mon profil"
        actionsDiv.classList.remove('hidden'); // Afficher les boutons "Sauvegarder" et "Annuler"
        passwordStrength.classList.remove('hidden'); // Afficher la force du mot de passe
    });

    // Annuler les modifications
    annulerBtn.addEventListener('click', function () {
        // Restaurer les valeurs initiales
        document.getElementById('nom').value = initialValues.nom;
        document.getElementById('prenom').value = initialValues.prenom;
        document.getElementById('email').value = initialValues.email;
        passwordInput.value = initialValues.password; // Réinitialiser le mot de passe à 8*
        togglePasswordBtn.classList.add('hidden'); // Cacher l'icône d'œil
        inputs.forEach(input => {
            input.disabled = true;
        });
        modifierBtn.classList.remove('hidden'); // Réafficher le bouton "Modifier mon profil"
        actionsDiv.classList.add('hidden'); // Masquer les boutons "Sauvegarder" et "Annuler"
        passwordStrength.classList.add('hidden'); // Masquer la force du mot de passe
    });

    // Afficher ou masquer le mot de passe
    togglePasswordBtn.addEventListener('click', function () {
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;
    });

    // Fonction pour calculer la force du mot de passe
    function checkPasswordStrength(password) {
        const lengthCriteria = password.length >= 8;
        const numberCriteria = /[0-9]/.test(password);
        const uppercaseCriteria = /[A-Z]/.test(password);
        const symbolCriteria = /[!@#$%^&*(),.?":{}|<>]/.test(password);

        let strength = 0;
        if (lengthCriteria) strength++;
        if (numberCriteria) strength++;
        if (uppercaseCriteria) strength++;
        if (symbolCriteria) strength++;

        if (strength === 0) {
            passwordStrength.textContent = "Très faible";
            passwordStrength.className = "weak";
        } else if (strength === 1) {
            passwordStrength.textContent = "Faible";
            passwordStrength.className = "weak";
        } else if (strength === 2) {
            passwordStrength.textContent = "Moyenne";
            passwordStrength.className = "medium";
        } else if (strength >= 3) {
            passwordStrength.textContent = "Forte";
            passwordStrength.className = "strong";
        }
    }

    // Écouter les changements du mot de passe
    passwordInput.addEventListener('input', function () {
        checkPasswordStrength(passwordInput.value);
    });
</script>

<script>
    <?php if (!empty($_SESSION['error_message'])): ?>
    Swal.fire({
        icon: 'error',
        title: 'Erreur',
        text: '<?= addslashes($_SESSION['error_message']) ?>',
    });
    <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success_message'])): ?>
    Swal.fire({
        icon: 'success',
        title: 'Succès',
        text: '<?= addslashes($_SESSION['success_message']) ?>',
    });
    <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
</script>
