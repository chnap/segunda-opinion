<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f8fafc">
    <title>Panel Privado</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,400&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: { DEFAULT: '#1e40af', light: '#3b82f6', dark: '#f8fafc' },
                        accent: '#f59e0b',
                        lightBg: '#f8fafc',
                        lightCard: '#ffffff',
                        lightBorder: '#eaeaea'
                    },
                    fontFamily: { 
                        serif: ['"Cormorant Garamond"', 'serif'], 
                        sans: ['"Manrope"', 'sans-serif'] 
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-lightBg text-slate-900 font-sans min-h-screen flex flex-col selection:bg-accent selection:text-lightBg antialiased m-0 p-0 relative overflow-x-hidden">

    <div class="fixed inset-0 opacity-15 pointer-events-none overflow-hidden z-0">
        <div class="absolute w-full max-w-7xl rounded-full -top-40 -left-1/2 opacity-15 pointer-events-none"></div>
        <div class="absolute w-full max-w-5xl rounded-full bottom-0 right-0 opacity-20"></div>
    </div>

    <header class="bg-lightCard/80 border-b border-lightBorder/80 sticky top-0 z-40 shadow-2xl">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 bg-gradient-to-br from-slate-200 to-slate-300 text-slate-700 rounded-2xl flex items-center justify-center font-serif font-bold text-2xl shadow-lg ring-1 ring-slate-200/40">+</div>
                <div>
                    <strong class="block font-serif text-slate-900 text-lg tracking-wide leading-tight">Dr. Juan De la Haba Rodríguez</strong>
                    <span class="text-[10px] uppercase tracking-[0.2em] text-slate-500 font-semibold">Panel Privado</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-2 bg-lightBg/80 px-4 py-2 rounded-2xl border border-lightBorder text-xs text-slate-500">
                    <i data-lucide="user-check" class="w-4 h-4 text-slate-500"></i>
                    <span><?php echo htmlspecialchars($_SESSION['user_email'] ?? 'admin@onco.com', ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <a href="login.php" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-slate-500 bg-lightCard/50 hover:bg-lightCard/60 border border-lightBorder/40 rounded-xl transition shadow-sm">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    <span>Salir</span>
                </a>
            </div>
        </div>
    </header>

    <main class="flex-grow max-w-7xl w-full mx-auto px-6 py-6 relative z-10">
        
        <div class="fade-in bg-lightCard/90 p-4 rounded-[24px] border border-lightBorder shadow-xl flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
            <div class="filters flex flex-wrap items-center gap-2">
                <button class="filter active px-4 py-2 text-xs font-semibold uppercase tracking-wider rounded-xl border border-slate-200 bg-slate-50/10 text-slate-600 transition cursor-pointer" data-filter="ALL">Todos los Casos</button>
                <button class="filter px-4 py-2 text-xs font-semibold uppercase tracking-wider rounded-xl border border-slate-200 text-slate-500 hover:border-slate-300 transition cursor-pointer" data-filter="URGENT">Urgentes / Prioritarios</button>
                <button class="filter px-4 py-2 text-xs font-semibold uppercase tracking-wider rounded-xl border border-slate-200 text-slate-500 hover:border-slate-300 transition cursor-pointer" data-filter="PENDING_TRIAGE">Triaje Pendiente</button>
                <button class="filter px-4 py-2 text-xs font-semibold uppercase tracking-wider rounded-xl border border-slate-200 text-slate-500 hover:border-slate-300 transition cursor-pointer" data-filter="DOCUMENTATION_PENDING">Falta Documentación</button>
                <button class="filter px-4 py-2 text-xs font-semibold uppercase tracking-wider rounded-xl border border-slate-200 text-slate-500 hover:border-slate-300 transition cursor-pointer" data-filter="REJECTED">Denegados</button>
            </div>
            <div class="relative min-w-[260px]">
                <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none w-4 h-4 text-slate-400"></i>
                <input id="caseSearch" type="search" placeholder="Buscar por paciente o patología..." class="w-full bg-white border border-slate-200 rounded-xl py-2.5 pl-10 sm:pl-11 pr-4 text-xs font-medium text-slate-700 focus:outline-none focus:border-slate-300 transition shadow-inner">
            </div>
        </div>

        <div class="fade-in bg-lightCard border border-lightBorder rounded-[28px] shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold uppercase tracking-widest text-slate-600">
                            <th class="py-5 px-6">Prioridad</th>
                            <th class="py-5 px-6">Paciente</th>
                            <th class="py-5 px-6">Patología / Motivo</th>
                            <th class="py-5 px-6">Estado</th>
                            <th class="py-5 px-6">Qué Falta</th>
                            <th class="py-5 px-6 text-right">Próxima Acción</th>
                        </tr>
                    </thead>
                    <tbody id="casesBody" class="divide-y divide-slate-200/60 text-sm text-slate-600">
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div class="modal-backdrop fixed inset-0 bg-slate-900/40 z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300" id="caseModal">
        <div class="modal bg-lightCard border border-lightBorder w-full max-w-4xl max-h-[90vh] rounded-[32px] shadow-2xl flex flex-col overflow-hidden scale-95 transition-transform duration-300">
            <div class="p-6 border-b border-lightBorder flex items-center justify-between bg-slate-50">
                <div class="flex items-center gap-4">
                    <div class="w-9 h-9 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center">
                        <i data-lucide="clipboard-check" class="w-5 h-5 text-slate-400"></i>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-slate-900">Gestión y Triaje del Caso</h3>
                </div>
                <button id="closeModal" class="w-8 h-8 rounded-xl border border-lightBorder text-slate-400 hover:text-slate-900 flex items-center justify-center transition cursor-pointer">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            <div id="modalContent" class="p-6 md:p-8 overflow-y-auto space-y-6 flex-grow"></div>
        </div>
    </div>

    <div id="toastContainer" class="fixed bottom-6 right-6 z-50 flex flex-col gap-2 pointer-events-none" aria-live="polite" aria-atomic="false"></div>

    <script src="main.js?v=2.1.0"></script>
</body>
</html>
