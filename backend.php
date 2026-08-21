<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#091318">
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
                        brand: { DEFAULT: '#123B45', light: '#1d5a66', dark: '#091318' },
                        accent: '#c59d63',
                        darkBg: '#091318',
                        darkCard: '#11222b',
                        darkBorder: '#1e3842'
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
<body class="bg-darkBg text-slate-100 font-sans min-h-screen flex flex-col selection:bg-accent selection:text-darkBg antialiased m-0 p-0 relative overflow-x-hidden">

    <div class="fixed inset-0 opacity-15 pointer-events-none overflow-hidden z-0">
        <div class="absolute w-[700px] h-[700px] bg-brand-light rounded-full blur-[200px] -top-40 -left-40"></div>
        <div class="absolute w-[500px] h-[500px] bg-accent rounded-full blur-[220px] bottom-0 right-0 opacity-20"></div>
    </div>

    <header class="bg-darkCard/80 backdrop-blur-xl border-b border-darkBorder/80 sticky top-0 z-40 shadow-2xl">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 bg-gradient-to-br from-accent to-[#967440] text-darkBg rounded-2xl flex items-center justify-center font-serif font-bold text-2xl shadow-lg ring-1 ring-accent/40">+</div>
                <div>
                    <strong class="block text-white font-serif text-lg tracking-wide leading-tight">Dr. Juan De la Haba Rodríguez</strong>
                    <span class="text-[10px] uppercase tracking-[0.2em] text-accent font-semibold">Panel Privado</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-2 bg-darkBg/80 px-4 py-2 rounded-2xl border border-darkBorder text-xs text-slate-300">
                    <i data-lucide="user-check" class="w-4 h-4 text-accent"></i>
                    <span><?php echo htmlspecialchars($_SESSION['user_email'] ?? 'admin@onco.com', ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <a href="login.php" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold uppercase tracking-wider text-rose-300 bg-rose-950/40 hover:bg-rose-900/60 border border-rose-800/40 rounded-xl transition shadow-sm">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                    <span>Salir</span>
                </a>
            </div>
        </div>
    </header>

    <main class="flex-grow max-w-7xl w-full mx-auto px-6 py-10 relative z-10 space-y-8">
        
        <div class="fade-in flex flex-col md:flex-row md:items-center justify-between gap-6 bg-darkCard/90 backdrop-blur-md p-8 rounded-[28px] border border-darkBorder shadow-2xl relative overflow-hidden">
            <div class="space-y-2 relative z-10">
                <h1 class="text-3xl md:text-4xl font-serif font-bold text-white">Gestión de Segundas Opiniones</h1>
            </div>
            <div class="shrink-0 relative z-10 flex items-center gap-3">
                <button id="resetDemo" class="px-4 py-2.5 bg-brand/40 hover:bg-brand/75 text-slate-200 text-xs font-semibold uppercase tracking-wider rounded-2xl border border-darkBorder hover:border-accent/40 transition shadow-md inline-flex items-center gap-2 cursor-pointer">
                    <i data-lucide="refresh-cw" class="w-4 h-4 text-accent"></i>
                    <span>Restablecer Datos</span>
                </button>
            </div>
        </div>

        <div class="fade-in bg-darkCard/90 backdrop-blur-md p-4 rounded-[24px] border border-darkBorder shadow-xl flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="filters flex flex-wrap items-center gap-2">
                <button class="filter active px-4 py-2 text-xs font-semibold uppercase tracking-wider rounded-xl border border-accent bg-accent/15 text-accent transition cursor-pointer" data-filter="ALL">Todos los Casos</button>
                <button class="filter px-4 py-2 text-xs font-semibold uppercase tracking-wider rounded-xl border border-darkBorder text-slate-300 hover:border-accent/50 transition cursor-pointer" data-filter="URGENT">Urgentes / Prioritarios</button>
                <button class="filter px-4 py-2 text-xs font-semibold uppercase tracking-wider rounded-xl border border-darkBorder text-slate-300 hover:border-accent/50 transition cursor-pointer" data-filter="PENDING_TRIAGE">Triaje Pendiente</button>
                <button class="filter px-4 py-2 text-xs font-semibold uppercase tracking-wider rounded-xl border border-darkBorder text-slate-300 hover:border-accent/50 transition cursor-pointer" data-filter="DOCUMENTATION_PENDING">Falta Documentación</button>
                <button class="filter px-4 py-2 text-xs font-semibold uppercase tracking-wider rounded-xl border border-rose-300 hover:border-rose-500/50 transition cursor-pointer" data-filter="REJECTED">Denegados</button>
            </div>
            <div class="relative min-w-[260px]">
                <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                <input id="caseSearch" type="search" placeholder="Buscar por paciente o patología..." class="w-full bg-darkBg border border-darkBorder rounded-xl py-2.5 pl-10 pr-4 text-xs font-medium text-white focus:outline-none focus:border-accent transition shadow-inner">
            </div>
        </div>

        <div class="fade-in bg-darkCard border border-darkBorder rounded-[28px] shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-brand/40 border-b border-darkBorder text-[11px] font-bold uppercase tracking-widest text-slate-300">
                            <th class="py-5 px-6">Prioridad</th>
                            <th class="py-5 px-6">Paciente</th>
                            <th class="py-5 px-6">Patología / Motivo</th>
                            <th class="py-5 px-6">Estado</th>
                            <th class="py-5 px-6">Qué Falta</th>
                            <th class="py-5 px-6 text-right">Próxima Acción</th>
                        </tr>
                    </thead>
                    <tbody id="casesBody" class="divide-y divide-darkBorder/60 text-sm"></tbody>
                </table>
            </div>
        </div>
    </main>

    <div class="modal-backdrop fixed inset-0 bg-black/80 backdrop-blur-md z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-all duration-300" id="caseModal">
        <div class="modal bg-darkCard border border-darkBorder w-full max-w-4xl max-h-[90vh] rounded-[32px] shadow-2xl flex flex-col overflow-hidden scale-95 transition-transform duration-300">
            <div class="p-6 border-b border-darkBorder flex items-center justify-between bg-brand/30">
                <div class="flex items-center gap-4">
                    <div class="w-9 h-9 rounded-xl bg-accent/15 border border-accent/30 text-accent flex items-center justify-center">
                        <i data-lucide="clipboard-check" class="w-5 h-5"></i>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-white">Gestión y Triaje del Caso</h3>
                </div>
                <button id="closeModal" class="w-8 h-8 rounded-xl bg-darkBg border border-darkBorder text-slate-400 hover:text-white flex items-center justify-center transition cursor-pointer">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
            <div id="modalContent" class="p-6 md:p-8 overflow-y-auto space-y-6 flex-grow"></div>
        </div>
    </div>

    <script src="main.js?v=2.1.0"></script>    
</body>
</html>