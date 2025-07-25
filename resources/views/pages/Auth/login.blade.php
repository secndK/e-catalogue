<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion * E-Catalogue</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, rgba(10, 25, 47, 1) 0%, rgba(67, 56, 202, 1) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Arrière-plan animé */
        .bg-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, rgba(10, 25, 47, 0.9), rgba(67, 56, 202, 0.9), rgba(10, 25, 47, 0.8), rgba(67, 56, 202, 0.7));
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            opacity: 1;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Particules flottantes */
        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }

        /* Container principal */
        .login-container {
            position: relative;
            z-index: 10;
            background: rgba(10, 25, 47, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(67, 56, 202, 0.3);
            border-radius: 24px;
            padding: 3rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 50px rgba(10, 25, 47, 0.4), 0 0 0 1px rgba(67, 56, 202, 0.1);
            animation: slideIn 0.8s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-header h1 {
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .login-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
            font-weight: 300;
        }

        /* Astérisque obligatoire */
        .required-asterisk {
            position: absolute;
            top: -8px;
            right: 12px;
            color: #ef4444;
            font-weight: bold;
            font-size: 1.2rem;
            z-index: 5;
        }

        .form-group {
            position: relative;
            margin-bottom: 1.75rem;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            background: rgba(10, 25, 47, 0.6);
            border: 1px solid rgba(67, 56, 202, 0.4);
            border-radius: 16px;
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .form-input:focus {
            outline: none;
            border-color: rgba(67, 56, 202, 0.8);
            background: rgba(10, 25, 47, 0.8);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(67, 56, 202, 0.3), 0 0 0 3px rgba(67, 56, 202, 0.1);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus+.form-icon {
            color: white;
            transform: translateY(-50%) scale(1.1);
        }

        /* Bouton de connexion */
        .login-btn {
            width: 100%;
            padding: 1.2rem;
            background: linear-gradient(135deg, rgba(67, 56, 202, 1), rgba(67, 56, 202, 0.8));
            border: none;
            border-radius: 16px;
            color: white;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 32px rgba(67, 56, 202, 0.4);
        }

        .login-btn:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(67, 56, 202, 0.6);
            background: linear-gradient(135deg, rgba(67, 56, 202, 1), rgba(10, 25, 47, 0.9));
        }

        .login-btn:hover:before {
            left: 100%;
        }

        .login-btn:active {
            transform: translateY(-1px);
        }

        /* Bouton d'accès guest */
        .guest-access {
            margin-bottom: 2rem;
        }

        .guest-btn {
            width: 100%;
            padding: 1rem;
            background: rgba(10, 25, 47, 0.6);
            border: 2px dashed rgba(67, 56, 202, 0.5);
            border-radius: 16px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            font-weight: 500;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .guest-btn:hover {
            background: rgba(67, 56, 202, 0.2);
            border-color: rgba(67, 56, 202, 0.8);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(67, 56, 202, 0.2);
        }

        .guest-btn i {
            font-size: 1.1rem;
        }

        /* Options supplémentaires */
        .login-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }

        .remember-me input {
            margin-right: 0.5rem;
            accent-color: rgba(67, 56, 202, 1);
        }

        .forgot-password {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .forgot-password:hover {
            color: white;
            text-shadow: 0 0 10px rgba(67, 56, 202, 0.8);
        }

        /* Séparateur */
        .divider {
            text-align: center;
            margin: 2rem 0;
            position: relative;
        }

        .divider:before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.3);
        }

        .divider span {
            background: rgba(10, 25, 47, 0.9);
            padding: 0 1rem;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        /* Boutons sociaux */
        .social-login {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .social-btn {
            flex: 1;
            padding: 0.8rem;
            border: 1px solid rgba(67, 56, 202, 0.4);
            border-radius: 12px;
            background: rgba(10, 25, 47, 0.6);
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .social-btn:hover {
            background: rgba(67, 56, 202, 0.3);
            border-color: rgba(67, 56, 202, 0.6);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(67, 56, 202, 0.3);
        }

        .social-btn i {
            font-size: 1.2rem;
        }

        /* Lien d'inscription */
        .signup-link {
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
        }

        .signup-link a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .signup-link a:hover {
            text-shadow: 0 0 10px rgba(67, 56, 202, 1);
        }

        /* Messages d'erreur */
        .error-message {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            color: #fca5a5;
            font-size: 0.9rem;
            animation: shake 0.5s ease-in-out;
            backdrop-filter: blur(10px);
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                margin: 1rem;
                padding: 2rem;
            }

            .login-header h1 {
                font-size: 2rem;
            }
        }

        /* Loading state */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .loading .login-btn {
            background: linear-gradient(135deg, rgba(67, 56, 202, 0.5), rgba(10, 25, 47, 0.7));
        }

        .loading .login-btn:after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <!-- Arrière-plan animé -->
    <div class="bg-animation"></div>

    <!-- Particules flottantes -->
    <div class="particles" id="particles"></div>

    <!-- Container de connexion -->
    <div class="login-container">
        <div class="login-header">
            <h1><i class="fas fa-rocket"></i> E-Catalogue</h1>
            <p>Connectez-vous à votre espace</p>
        </div>

        <!-- Messages d'erreur (Laravel) -->
        @if ($errors->any())
            <div class="error-message">
                <i class="fas fa-exclamation-triangle"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <div class="form-group">

                <input type="text" class="form-input" name="mat_ag" placeholder="Matricule"
                    value="{{ old('mat_ag') }}" required autocomplete="mat_ag" autofocus>
                <i class="fas fa-id-badge form-icon"></i>
            </div>

            <div class="form-group">
                <input type="password" class="form-input" name="password" placeholder="Mot de passe" required
                    autocomplete="current-password">
                <i class="fas fa-lock form-icon"></i>
            </div>


            <button type="submit" class="login-btn" id="loginBtn">
                <span>Se connecter en tant qu'Admin</span>
            </button>
        </form>

        <div class="guest-access">
            <a href="{{ route('guest.access') }}" class="guest-btn">
                <i class="fas fa-eye"></i>
                <span>Accéder au catalogue en tant que visiteur</span>
            </a>
        </div>




    </div>

    <script>
        // Génération des particules
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 50;

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';

                const size = Math.random() * 6 + 2;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 20 + 's';
                particle.style.animationDuration = (Math.random() * 10 + 15) + 's';

                particlesContainer.appendChild(particle);
            }
        }

        // Animation du formulaire
        function animateForm() {
            const inputs = document.querySelectorAll('.form-input');

            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });
        }

        // Gestion du loading state
        function handleFormSubmit() {
            const form = document.getElementById('loginForm');
            const container = document.querySelector('.login-container');

            form.addEventListener('submit', function() {
                container.classList.add('loading');
            });
        }

        // Effet de parallaxe sur la souris
        function parallaxEffect() {
            document.addEventListener('mousemove', function(e) {
                const container = document.querySelector('.login-container');
                const x = (e.clientX / window.innerWidth) * 100;
                const y = (e.clientY / window.innerHeight) * 100;

                container.style.transform = `translate(${(x - 50) * 0.02}px, ${(y - 50) * 0.02}px)`;
            });
        }

        // Animation d'apparition séquentielle
        function sequentialAnimation() {
            const elements = [
                '.login-header h1',
                '.login-header p',
                '.form-group',
                '.login-options',
                '.login-btn',
                '.divider',
                '.social-login',
                '.signup-link'
            ];

            elements.forEach((selector, index) => {
                const els = document.querySelectorAll(selector);
                els.forEach(el => {
                    el.style.opacity = '0';
                    el.style.transform = 'translateY(20px)';

                    setTimeout(() => {
                        el.style.transition = 'all 0.6s ease';
                        el.style.opacity = '1';
                        el.style.transform = 'translateY(0)';
                    }, index * 150);
                });
            });
        }

        // Validation en temps réel
        function realTimeValidation() {
            const emailInput = document.querySelector('input[name="email"]');
            const passwordInput = document.querySelector('input[name="password"]');

            emailInput.addEventListener('input', function() {
                const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value);
                this.style.borderColor = isValid || this.value === '' ?
                    'rgba(67, 56, 202, 0.4)' : 'rgba(239, 68, 68, 0.6)';
            });

            passwordInput.addEventListener('input', function() {
                const isValid = this.value.length >= 6;
                this.style.borderColor = isValid || this.value === '' ?
                    'rgba(67, 56, 202, 0.4)' : 'rgba(239, 68, 68, 0.6)';
            });
        }

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            createParticles();
            animateForm();
            handleFormSubmit();
            parallaxEffect();
            sequentialAnimation();
            realTimeValidation();
        });
    </script>
</body>

</html>
