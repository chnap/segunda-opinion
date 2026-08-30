<?php
session_start();
require 'conexion_db.php';

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT id, username, email, password_hash, role FROM backend_users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        header("Location: backend.php");
        exit();
    } else {
        $error = "Credenciales incorrectas.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Segunda Opinión Oncológica</title>
    
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,400&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: { DEFAULT: '#1e40af', light: #3b82f6, dark: #f8fafc },
                        accent: #f59e0b,
                        lightBg: #f8fafc,
                        lightCard: #ffffff,
                        lightBorder: #eaeaea
                    },
                    fontFamily: { 
                        serif: ['"Cormorant Garamond"', 'serif'], 
                        sans: ['"Manrope"', 'sans-serif'] 
                    }
                }
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-lightBg text-slate-900 font-sans min-h-screen flex items-center justify-center overflow-hidden relative selection:bg-accent selection:text-lightBg antialiased m-0 p-0 relative overflow-x-hidden">

    <div class="absolute inset-0 opacity-20 pointer-events-none" id="bg-pattern">
        <div class="absolute w-[500px] h-[500px] bg-[#1d5a66] rounded-full blur-[120px] -top-20 -left-20"></div>
        <div class="absolute w-[400px] h-[400px] bg-[#c59d63] rounded-full blur-[150px] bottom-10 right-10 opacity-30"></div>
    </div>

    <div class="relative z-10 w-full max-w-md p-10 bg-lightCard/90 backdrop-blur-md border border-lightBorder rounded-xl shadow-xl">
        <div class="text-center mb-10 stagger-el">
            <div class="w-16 h-16 bg-white text-slate-700 rounded-2xl mx-auto flex items-center justify-center text-3xl mb-4 font-light shadow-lg">+</div>
            <span class="font-serif text-2xl tracking-wide font-bold text-slate-900 block mb-1">Dr. Juan De la Haba</span>
            <span class="text-[10px] uppercase tracking-[0.2em] text-slate-500 font-semibold">Panel Privado · Segunda Opinión</span>
        </div>

        <form id="login-form" method="POST" action="login.php" class="space-y-6">
            <div class="stagger-el relative">
                <label class="block text-xs uppercase tracking-wider text-slate-500/70 mb-2 font-semibold">Usuario o Email</label>
                <div class="relative">
                    <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                    <input type="text" name="username" id="username" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 pl-11 pr-4 text-sm text-slate-700 focus:outline-none focus:border-slate-300 transition shadow-inner" required>
                </div>
            </div>

            <div class="stagger-el relative">
                <label class="block text-xs uppercase tracking-wider text-slate-500/70 mb-2 font-semibold">Contraseña</label>
                <div class="relative">
                    <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                    <input type="password" name="password" id="password" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 pl-11 pr-4 text-sm text-slate-700 focus:outline-none focus:border-slate-300 transition shadow-inner" required>
                </div>
            </div>

            <div class="stagger-el pt-4">
                <button type="submit" class="w-full bg-slate-600 text-slate-100 py-4 rounded-xl font-bold text-sm text-xs font-medium uppercase tracking-wider hover:bg-slate-500 transition transform hover:scale-[1.02] shadow-sm shadow-slate-200/20 flex justify-center items-center gap-2 border-0 cursor-pointer">
                    <span>Acceder al Sistema</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </button>
            </div>
            
            <?php if (!empty($error)): ?>
                <p class="text-slate-500 text-xs text-center stagger-el font-semibold uppercase tracking-wider mt-4"><?php echo $error; ?></p>
            <?php endif; ?>
        </form>
    </div>

    <script>
        lucide.createIcons();

        gsap.fromTo(".login-box", 
            { y: 40, opacity: 0 },
            { y: 0, opacity: 1, duration: 1, ease: "power4.out" }
        );

        gsap.fromTo(".stagger-el", 
            { y: 20, opacity: 0 },
            { y: 0, opacity: 1, duration: 0.8, stagger: 0.1, delay: 0.2, ease: "power3.out" }
        );

        document.getElementById('login-form').addEventListener('submit', function() {
            const btn = this.querySelector('button');
            btn.innerHTML = '<i data-lucide="loader-2" class="w-5 h-5 animate-spin"></i> Verificando...';
            lucide.createIcons();
        });
    </script>
</body>
</html>