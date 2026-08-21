<?php
// Configuración básica e inicialización si es necesaria
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Servicio de segunda opinión oncológica. Valoración médica especializada por el Dr. Juan De la Haba Rodríguez.">
    <meta name="theme-color" content="#123B45">
    <title>Segunda Opinión Oncológica | Dr. Juan De la Haba</title>
    
    <!-- Tipografía Editorial Premium -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400;1,600&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        deepTeal: '#123B45',
                        darkTeal: '#091318',
                        softIvory: '#F7F5F0',
                        warmWhite: '#FCFBF8',
                        mutedTeal: '#55777D',
                        goldAccent: '#C59D63',
                        goldLight: '#E3C896',
                        darkText: '#17252A',
                        greyText: '#6D777A'
                    },
                    fontFamily: { 
                        serif: ['"Cormorant Garamond"', 'serif'], 
                        sans: ['"Manrope"', 'sans-serif'] 
                    },
                    boxShadow: {
                        'premium': '0 20px 50px -10px rgba(18, 59, 69, 0.08), 0 10px 20px -15px rgba(197, 157, 99, 0.15)',
                        'gold-glow': '0 0 25px rgba(197, 157, 99, 0.25)',
                        'inner-light': 'inset 0 1px 1px rgba(255, 255, 255, 0.6)'
                    }
                }
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* Estilos auxiliares para animaciones y estética Premium */
        .reveal-fade-up, .reveal-fade-left, .reveal-fade-right, .reveal-stagger > * {
            will-change: transform, opacity;
        }
        .luxury-card {
            background: linear-gradient(135deg, rgba(252, 251, 248, 0.95) 0%, rgba(247, 245, 240, 0.8) 100%);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(197, 157, 99, 0.18);
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .luxury-card:hover {
            border-color: rgba(197, 157, 99, 0.45);
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -15px rgba(18, 59, 69, 0.12), 0 0 20px rgba(197, 157, 99, 0.15);
        }
        .gold-gradient-text {
            background: linear-gradient(135deg, #C59D63 0%, #E3C896 50%, #9E7943 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gold-border-glow {
            position: relative;
        }
        .gold-border-glow::after {
            content: '';
            position: absolute;
            inset: -1px;
            background: linear-gradient(90deg, rgba(197,157,99,0.3), rgba(18,59,69,0.1), rgba(197,157,99,0.3));
            border-radius: inherit;
            z-index: -1;
            opacity: 0.5;
            transition: opacity 0.5s ease;
        }
        .gold-border-glow:hover::after {
            opacity: 1;
        }
        /* Custom inputs premium focus */
        .premium-input {
            border-bottom: 1px solid rgba(18, 59, 69, 0.2);
            transition: all 0.4s ease;
        }
        .premium-input:focus {
            border-bottom-color: #C59D63;
            box-shadow: 0 2px 10px -2px rgba(197, 157, 99, 0.3);
        }
    </style>
</head>
<body class="bg-warmWhite text-darkText font-sans min-h-screen flex flex-col selection:bg-goldAccent/30 selection:text-darkTeal antialiased overflow-x-hidden relative">

    <!-- Efecto de luz ambiental superior -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[400px] bg-gradient-to-b from-goldAccent/10 via-deepTeal/5 to-transparent blur-3xl pointer-events-none -z-10"></div>

    <!-- HEADER MINIMALISTA & GLASSMORPHIC -->
    <header id="site-header" class="fixed w-full top-0 z-50 bg-warmWhite/80 backdrop-blur-xl border-b border-goldAccent/15 transition-all duration-500 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 h-24 flex items-center justify-between header-container transition-all duration-500">
            <a href="#inicio" class="flex flex-col no-underline group focus:outline-none focus:ring-2 focus:ring-goldAccent/50 rounded-sm p-1">
                <strong class="font-serif text-xl tracking-wide text-darkTeal group-hover:text-goldAccent transition-colors duration-300">Dr. Juan De la Haba Rodríguez</strong>
                <span class="text-[10px] uppercase tracking-[0.25em] text-mutedTeal font-semibold flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-goldAccent inline-block"></span>
                    Oncología Médica
                </span>
            </a>
            
            <nav class="hidden md:flex items-center gap-10 text-sm font-medium tracking-wide">
                <a href="#como-funciona" class="text-greyText hover:text-deepTeal transition-colors relative py-1 after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-px after:bg-goldAccent hover:after:w-full after:transition-all after:duration-300">Cómo funciona</a>
                <a href="#especialista" class="text-greyText hover:text-deepTeal transition-colors relative py-1 after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-px after:bg-goldAccent hover:after:w-full after:transition-all after:duration-300">El especialista</a>
                <a href="#faq" class="text-greyText hover:text-deepTeal transition-colors relative py-1 after:content-[''] after:absolute after:bottom-0 after:left-0 after:w-0 after:h-px after:bg-goldAccent hover:after:w-full after:transition-all after:duration-300">Preguntas frecuentes</a>
            </nav>

            <a class="hidden md:inline-flex px-7 py-3 bg-deepTeal text-warmWhite text-xs uppercase tracking-widest hover:bg-darkTeal transition-all duration-400 focus:outline-none focus:ring-2 focus:ring-goldAccent/50 border border-goldAccent/30 hover:border-goldAccent shadow-md hover:shadow-lg relative overflow-hidden group" href="#solicitar">
                <span class="relative z-10">Solicitar valoración</span>
                <span class="absolute inset-0 bg-goldAccent/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out"></span>
            </a>

            <!-- Mobile menu button -->
            <button class="md:hidden text-deepTeal p-2 rounded-lg hover:bg-goldAccent/10 transition-colors focus:outline-none" aria-label="Abrir menú">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>
    </header>

    <main id="inicio" class="flex-grow pt-24">
        
        <!-- HERO EDITORIAL -->
        <section class="max-w-7xl mx-auto px-6 py-16 md:py-32 grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20 items-center min-h-[85vh] relative">
            <div class="lg:col-span-6 space-y-10 reveal-fade-up">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-softIvory border border-goldAccent/30 shadow-inner-light">
                    <span class="w-2 h-2 rounded-full bg-goldAccent animate-pulse"></span>
                    <span class="text-[11px] uppercase tracking-widest text-mutedTeal font-semibold">Atención Especializada</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-serif text-darkTeal leading-[1.12] tracking-tight">
                    Una segunda mirada puede ayudarte a entender mejor tus opciones.
                </h1>
                <p class="text-mutedTeal text-lg md:text-xl font-light leading-relaxed max-w-lg">
                    Valoración especializada de tu situación oncológica, basada en la revisión de tu información clínica y en una consulta médica personalizada.
                </p>
                <div class="flex flex-col sm:flex-row gap-6 pt-4">
                    <a class="px-8 py-4 bg-deepTeal text-warmWhite text-xs uppercase tracking-widest text-center hover:bg-darkTeal transition-all duration-400 border border-goldAccent/40 hover:border-goldAccent shadow-lg hover:shadow-gold-glow relative overflow-hidden group" href="#solicitar">
                        <span class="relative z-10">Solicitar segunda opinión</span>
                        <span class="absolute inset-0 bg-gradient-to-r from-goldAccent/0 via-goldAccent/20 to-goldAccent/0 -translate-x-full group-hover:translate-x-full transition-transform duration-1000"></span>
                    </a>
                    <a class="px-8 py-4 bg-transparent text-deepTeal border border-deepTeal/30 hover:border-goldAccent text-xs uppercase tracking-widest text-center hover:bg-softIvory transition-all duration-400" href="#como-funciona">
                        Cómo funciona
                    </a>
                </div>
                <p class="text-xs text-greyText tracking-wide font-medium flex items-center gap-3 pt-2">
                    <span class="w-10 h-px bg-gradient-to-r from-goldAccent to-transparent"></span>
                    Proceso online · Atención especializada · Confidencialidad
                </p>
            </div>

            <!-- FOTO HERO CON MARCO DE LUJO -->
            <div class="lg:col-span-6 h-full reveal-fade-left">
                <div class="relative p-3 bg-gradient-to-b from-goldAccent/30 via-goldAccent/10 to-deepTeal/10 rounded-2xl shadow-premium">
                    <div class="aspect-[3/4] md:aspect-[4/5] bg-softIvory relative overflow-hidden rounded-xl group border border-warmWhite">
                        <div class="absolute inset-0 bg-[url('')] bg-cover bg-center opacity-90 transition-transform duration-1000 group-hover:scale-105 filter grayscale-[15%]"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-darkTeal/60 via-darkTeal/10 to-transparent"></div>
                        <div class="absolute bottom-6 left-6 right-6 p-6 backdrop-blur-md bg-warmWhite/80 rounded-lg border border-goldAccent/20 shadow-lg transform translate-y-2 group-hover:translate-y-0 transition-transform duration-500">
                            <p class="font-serif text-darkTeal font-semibold text-lg">Dr. Juan De la Haba Rodríguez</p>
                            <p class="text-xs text-mutedTeal uppercase tracking-widest mt-0.5">Especialista en Oncología Médica</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- BLOQUE DE CONFIANZA -->
        <section class="border-y border-goldAccent/20 bg-gradient-to-b from-softIvory to-warmWhite py-20 relative">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 reveal-stagger">
                    
                    <div class="luxury-card p-8 rounded-xl space-y-4">
                        <div class="w-10 h-10 rounded-lg bg-goldAccent/10 flex items-center justify-center text-goldAccent border border-goldAccent/30">
                            <i data-lucide="microscope" class="w-5 h-5 stroke-[1.5]"></i>
                        </div>
                        <h3 class="text-xs uppercase tracking-widest text-deepTeal font-bold">Oncología Médica</h3>
                        <p class="text-sm text-greyText leading-relaxed font-light">Especialización médica centrada de forma exclusiva en el paciente oncológico.</p>
                    </div>

                    <div class="luxury-card p-8 rounded-xl space-y-4">
                        <div class="w-10 h-10 rounded-lg bg-goldAccent/10 flex items-center justify-center text-goldAccent border border-goldAccent/30">
                            <i data-lucide="user-focus" class="w-5 h-5 stroke-[1.5]"></i>
                        </div>
                        <h3 class="text-xs uppercase tracking-widest text-deepTeal font-bold">Valoración Personalizada</h3>
                        <p class="text-sm text-greyText leading-relaxed font-light">Cada caso se revisa de manera exhaustiva de acuerdo con su situación clínica particular.</p>
                    </div>

                    <div class="luxury-card p-8 rounded-xl space-y-4">
                        <div class="w-10 h-10 rounded-lg bg-goldAccent/10 flex items-center justify-center text-goldAccent border border-goldAccent/30">
                            <i data-lucide="laptop" class="w-5 h-5 stroke-[1.5]"></i>
                        </div>
                        <h3 class="text-xs uppercase tracking-widest text-deepTeal font-bold">Proceso Online</h3>
                        <p class="text-sm text-greyText leading-relaxed font-light">Puedes iniciar el proceso de revisión y consulta sin necesidad de desplazarte.</p>
                    </div>

                    <div class="luxury-card p-8 rounded-xl space-y-4">
                        <div class="w-10 h-10 rounded-lg bg-goldAccent/10 flex items-center justify-center text-goldAccent border border-goldAccent/30">
                            <i data-lucide="lock" class="w-5 h-5 stroke-[1.5]"></i>
                        </div>
                        <h3 class="text-xs uppercase tracking-widest text-deepTeal font-bold">Confidencialidad</h3>
                        <p class="text-sm text-greyText leading-relaxed font-light">La información clínica se gestiona mediante sistemas destinados a la atención sanitaria.</p>
                    </div>

                </div>
            </div>
        </section>

        <!-- ¿CUÁNDO PUEDE SER ÚTIL? -->
        <section class="py-28 md:py-36 max-w-7xl mx-auto px-6 grid md:grid-cols-12 gap-16 items-start">
            <div class="md:col-span-5 md:sticky md:top-32 reveal-fade-up space-y-4">
                <span class="text-[10px] uppercase tracking-[0.25em] text-goldAccent font-bold block border-l-2 border-goldAccent pl-3">Contexto Clínico</span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-serif text-darkTeal leading-tight">¿Cuándo puede ser útil solicitar una segunda opinión?</h2>
                <p class="text-sm text-mutedTeal pt-2">Orientación clara para momentos de incertidumbre diagnóstica o terapéutica.</p>
            </div>
            
            <div class="md:col-span-7 border-l border-goldAccent/20 pl-6 md:pl-12 space-y-8 reveal-stagger">
                <p class="text-greyText text-lg font-light leading-relaxed mb-10">Una revisión independiente aporta claridad y perspectiva en diferentes momentos del proceso médico.</p>
                
                <ul class="space-y-6">
                    <li class="p-5 rounded-xl bg-softIvory/60 border border-goldAccent/10 hover:border-goldAccent/40 transition-all duration-300 flex items-start gap-5 group">
                        <span class="w-2.5 h-2.5 rounded-full bg-goldAccent mt-2 flex-shrink-0 group-hover:scale-125 transition-transform duration-300 shadow-gold-glow"></span>
                        <span class="text-darkTeal text-base md:text-lg font-medium leading-snug">Has recibido recientemente un diagnóstico oncológico.</span>
                    </li>
                    <li class="p-5 rounded-xl bg-softIvory/60 border border-goldAccent/10 hover:border-goldAccent/40 transition-all duration-300 flex items-start gap-5 group">
                        <span class="w-2.5 h-2.5 rounded-full bg-goldAccent mt-2 flex-shrink-0 group-hover:scale-125 transition-transform duration-300 shadow-gold-glow"></span>
                        <span class="text-darkTeal text-base md:text-lg font-medium leading-snug">Quieres revisar detalladamente una propuesta de tratamiento.</span>
                    </li>
                    <li class="p-5 rounded-xl bg-softIvory/60 border border-goldAccent/10 hover:border-goldAccent/40 transition-all duration-300 flex items-start gap-5 group">
                        <span class="w-2.5 h-2.5 rounded-full bg-goldAccent mt-2 flex-shrink-0 group-hover:scale-125 transition-transform duration-300 shadow-gold-glow"></span>
                        <span class="text-darkTeal text-base md:text-lg font-medium leading-snug">Existen varias alternativas terapéuticas y deseas valorarlas.</span>
                    </li>
                    <li class="p-5 rounded-xl bg-softIvory/60 border border-goldAccent/10 hover:border-goldAccent/40 transition-all duration-300 flex items-start gap-5 group">
                        <span class="w-2.5 h-2.5 rounded-full bg-goldAccent mt-2 flex-shrink-0 group-hover:scale-125 transition-transform duration-300 shadow-gold-glow"></span>
                        <span class="text-darkTeal text-base md:text-lg font-medium leading-snug">Tienes dudas fundadas sobre el siguiente paso a dar.</span>
                    </li>
                    <li class="p-5 rounded-xl bg-softIvory/60 border border-goldAccent/10 hover:border-goldAccent/40 transition-all duration-300 flex items-start gap-5 group">
                        <span class="w-2.5 h-2.5 rounded-full bg-goldAccent mt-2 flex-shrink-0 group-hover:scale-125 transition-transform duration-300 shadow-gold-glow"></span>
                        <span class="text-darkTeal text-base md:text-lg font-medium leading-snug">Quieres contrastar una decisión médica importante.</span>
                    </li>
                    <li class="p-5 rounded-xl bg-softIvory/60 border border-goldAccent/10 hover:border-goldAccent/40 transition-all duration-300 flex items-start gap-5 group">
                        <span class="w-2.5 h-2.5 rounded-full bg-goldAccent mt-2 flex-shrink-0 group-hover:scale-125 transition-transform duration-300 shadow-gold-glow"></span>
                        <span class="text-darkTeal text-base md:text-lg font-medium leading-snug">Buscas una valoración especializada adicional sobre tu evolución.</span>
                    </li>
                </ul>
            </div>
        </section>

        <!-- QUÉ SE REVISA (DARK EDITORIAL SECTION) -->
        <section class="py-28 bg-darkTeal text-warmWhite relative overflow-hidden border-y border-goldAccent/20">
            <!-- Glow ambiental oscuro -->
            <div class="absolute -right-20 top-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-deepTeal/40 rounded-full blur-3xl pointer-events-none"></div>

            <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-16 relative z-10 items-center">
                <div class="space-y-8 reveal-fade-up">
                    <span class="text-[10px] uppercase tracking-[0.25em] text-goldAccent font-bold">Rigor Clínico</span>
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-serif leading-tight">La revisión clínica</h2>
                    <p class="text-softIvory/80 text-lg font-light leading-relaxed">
                        Durante el proceso de estudio, el especialista evalúa cuidadosamente la documentación disponible para construir una visión completa de la situación.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm font-medium reveal-stagger">
                    <div class="flex items-center gap-4 p-4 rounded-lg bg-deepTeal/40 border border-goldAccent/20 backdrop-blur-md hover:border-goldAccent/50 transition-colors">
                        <span class="w-7 h-7 rounded-full bg-goldAccent/20 flex items-center justify-center text-goldAccent flex-shrink-0">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </span>
                        <span>Diagnóstico</span>
                    </div>
                    <div class="flex items-center gap-4 p-4 rounded-lg bg-deepTeal/40 border border-goldAccent/20 backdrop-blur-md hover:border-goldAccent/50 transition-colors">
                        <span class="w-7 h-7 rounded-full bg-goldAccent/20 flex items-center justify-center text-goldAccent flex-shrink-0">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </span>
                        <span>Estadio de la enfermedad</span>
                    </div>
                    <div class="flex items-center gap-4 p-4 rounded-lg bg-deepTeal/40 border border-goldAccent/20 backdrop-blur-md hover:border-goldAccent/50 transition-colors">
                        <span class="w-7 h-7 rounded-full bg-goldAccent/20 flex items-center justify-center text-goldAccent flex-shrink-0">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </span>
                        <span>Anatomía patológica</span>
                    </div>
                    <div class="flex items-center gap-4 p-4 rounded-lg bg-deepTeal/40 border border-goldAccent/20 backdrop-blur-md hover:border-goldAccent/50 transition-colors">
                        <span class="w-7 h-7 rounded-full bg-goldAccent/20 flex items-center justify-center text-goldAccent flex-shrink-0">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </span>
                        <span>Pruebas de imagen</span>
                    </div>
                    <div class="flex items-center gap-4 p-4 rounded-lg bg-deepTeal/40 border border-goldAccent/20 backdrop-blur-md hover:border-goldAccent/50 transition-colors">
                        <span class="w-7 h-7 rounded-full bg-goldAccent/20 flex items-center justify-center text-goldAccent flex-shrink-0">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </span>
                        <span>Tratamientos realizados</span>
                    </div>
                    <div class="flex items-center gap-4 p-4 rounded-lg bg-deepTeal/40 border border-goldAccent/20 backdrop-blur-md hover:border-goldAccent/50 transition-colors">
                        <span class="w-7 h-7 rounded-full bg-goldAccent/20 flex items-center justify-center text-goldAccent flex-shrink-0">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </span>
                        <span>Tratamientos propuestos</span>
                    </div>
                    <div class="flex items-center gap-4 p-4 rounded-lg bg-deepTeal/40 border border-goldAccent/20 backdrop-blur-md hover:border-goldAccent/50 transition-colors">
                        <span class="w-7 h-7 rounded-full bg-goldAccent/20 flex items-center justify-center text-goldAccent flex-shrink-0">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </span>
                        <span>Analíticas relevantes</span>
                    </div>
                    <div class="flex items-center gap-4 p-4 rounded-lg bg-deepTeal/40 border border-goldAccent/20 backdrop-blur-md hover:border-goldAccent/50 transition-colors">
                        <span class="w-7 h-7 rounded-full bg-goldAccent/20 flex items-center justify-center text-goldAccent flex-shrink-0">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </span>
                        <span>Información genómica (si procede)</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- CÓMO FUNCIONA -->
        <section id="como-funciona" class="py-28 md:py-36 bg-warmWhite relative">
            <div class="max-w-5xl mx-auto px-6">
                <div class="text-center mb-24 reveal-fade-up space-y-3">
                    <span class="text-[10px] uppercase tracking-[0.25em] text-goldAccent font-bold block">Metodología</span>
                    <h2 class="text-3xl md:text-5xl font-serif text-darkTeal">El desarrollo del proceso</h2>
                    <div class="w-12 h-0.5 bg-goldAccent mx-auto mt-4"></div>
                </div>

                <div class="space-y-16 relative before:absolute before:inset-0 before:ml-4 md:before:ml-[50%] before:-translate-x-px md:before:translate-x-[-0.5px] before:w-0.5 before:bg-gradient-to-b before:from-goldAccent/20 before:via-goldAccent before:to-goldAccent/20">
                    
                    <!-- Step 1 -->
                    <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-8 reveal-fade-up">
                        <div class="hidden md:block w-[45%] text-right pr-12">
                            <div class="p-6 rounded-xl bg-softIvory border border-goldAccent/15 shadow-sm hover:border-goldAccent/40 transition-all">
                                <h3 class="text-xl font-serif text-darkTeal font-semibold mb-2">Cuéntanos tu caso</h3>
                                <p class="text-sm text-greyText font-light leading-relaxed">Completas una breve solicitud inicial explicando tu situación clínica y las dudas que deseas valorar.</p>
                            </div>
                        </div>
                        <div class="absolute left-0 md:left-1/2 -translate-x-1/2 flex items-center justify-center w-10 h-10 bg-warmWhite border-2 border-goldAccent text-goldAccent font-serif italic text-base rounded-full shadow-gold-glow z-10">01</div>
                        <div class="md:hidden pl-12">
                            <div class="p-6 rounded-xl bg-softIvory border border-goldAccent/15 shadow-sm">
                                <h3 class="text-xl font-serif text-darkTeal font-semibold mb-2">Cuéntanos tu caso</h3>
                                <p class="text-sm text-greyText font-light">Completas una breve solicitud inicial explicando tu situación y las dudas a valorar.</p>
                            </div>
                        </div>
                        <div class="hidden md:block w-[45%] pl-12"></div>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-8 reveal-fade-up">
                        <div class="hidden md:block w-[45%] pr-12"></div>
                        <div class="absolute left-0 md:left-1/2 -translate-x-1/2 flex items-center justify-center w-10 h-10 bg-warmWhite border-2 border-goldAccent text-goldAccent font-serif italic text-base rounded-full shadow-gold-glow z-10">02</div>
                        <div class="w-full md:w-[45%] pl-12">
                            <div class="p-6 rounded-xl bg-softIvory border border-goldAccent/15 shadow-sm hover:border-goldAccent/40 transition-all">
                                <h3 class="text-xl font-serif text-darkTeal font-semibold mb-2">Valoración y Triaje</h3>
                                <p class="text-sm text-greyText font-light leading-relaxed">El médico revisa la información inicial y determina médica y éticamente si el servicio es adecuado para tu caso particular.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-8 reveal-fade-up">
                        <div class="hidden md:block w-[45%] text-right pr-12">
                            <div class="p-6 rounded-xl bg-softIvory border border-goldAccent/15 shadow-sm hover:border-goldAccent/40 transition-all">
                                <h3 class="text-xl font-serif text-darkTeal font-semibold mb-2">Completa la documentación</h3>
                                <p class="text-sm text-greyText font-light leading-relaxed">Si el caso es aceptado, recibirás instrucciones privadas para aportar de forma segura la documentación clínica requerida.</p>
                            </div>
                        </div>
                        <div class="absolute left-0 md:left-1/2 -translate-x-1/2 flex items-center justify-center w-10 h-10 bg-warmWhite border-2 border-goldAccent text-goldAccent font-serif italic text-base rounded-full shadow-gold-glow z-10">03</div>
                        <div class="md:hidden pl-12">
                            <div class="p-6 rounded-xl bg-softIvory border border-goldAccent/15 shadow-sm">
                                <h3 class="text-xl font-serif text-darkTeal font-semibold mb-2">Completa la documentación</h3>
                                <p class="text-sm text-greyText font-light">Si el caso es aceptado, recibirás instrucciones para aportar la documentación clínica necesaria de forma segura.</p>
                            </div>
                        </div>
                        <div class="hidden md:block w-[45%] pl-12"></div>
                    </div>

                    <!-- Step 4 -->
                    <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-8 reveal-fade-up">
                        <div class="hidden md:block w-[45%] pr-12"></div>
                        <div class="absolute left-0 md:left-1/2 -translate-x-1/2 flex items-center justify-center w-10 h-10 bg-deepTeal border-2 border-goldAccent text-warmWhite font-serif italic text-base rounded-full shadow-lg z-10">04</div>
                        <div class="w-full md:w-[45%] pl-12">
                            <div class="p-6 rounded-xl bg-deepTeal text-warmWhite border border-goldAccent/30 shadow-lg">
                                <h3 class="text-xl font-serif text-warmWhite font-semibold mb-2">Consulta Médica</h3>
                                <p class="text-sm text-softIvory/80 font-light leading-relaxed">Se realiza la consulta online con el especialista, dedicando el tiempo necesario a abordar el caso y resolver dudas.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- SOBRE EL MÉDICO -->
        <section id="especialista" class="py-28 bg-softIvory border-t border-goldAccent/20 relative">
            <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-12 gap-16 items-center">
                <div class="md:col-span-5 reveal-fade-right">
                    <div class="p-3 bg-warmWhite rounded-2xl border border-goldAccent/20 shadow-premium">
                        <div class="aspect-[3/4] rounded-xl overflow-hidden bg-mutedTeal/20 bg-[url('')] bg-cover bg-center filter grayscale-[20%]"></div>
                    </div>
                </div>
                <div class="md:col-span-7 space-y-8 reveal-fade-left">
                    <div>
                        <span class="text-[10px] uppercase tracking-[0.25em] text-goldAccent font-bold block mb-2">Dirección Médica</span>
                        <h2 class="text-3xl md:text-4xl lg:text-5xl font-serif text-darkTeal">Dr. Juan De la Haba Rodríguez</h2>
                        <p class="text-goldAccent font-serif italic text-xl mt-1">Oncólogo</p>
                    </div>
                    
                    <div class="space-y-6 text-greyText font-light leading-relaxed text-base md:text-lg">
                        <p>Descripción profesional del médico centrada en el diagnóstico y tratamiento del paciente oncológico, con máxima dedicación y rigor.</p>
                        <p>Enfoque hacia el paciente priorizando la claridad, el rigor científico y el acompañamiento constante durante la toma de decisiones.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FORMULARIO INICIAL CON ESTILO PREMIUM -->
        <section id="solicitar" class="py-28 bg-gradient-to-b from-softIvory to-warmWhite border-y border-goldAccent/20 relative">
            <div class="max-w-3xl mx-auto px-6 space-y-12">
                <div class="text-center space-y-4 reveal-fade-up">
                    <span class="text-[10px] uppercase tracking-[0.25em] text-goldAccent font-bold">Inicia tu Consulta</span>
                    <h2 class="text-3xl md:text-5xl font-serif text-darkTeal">Cuéntanos tu caso</h2>
                    <p class="text-greyText text-sm md:text-base max-w-lg mx-auto font-light leading-relaxed">La información proporcionada será revisada de forma confidencial para determinar si el servicio médico puede aportar valor a tu situación.</p>
                </div>

                <div class="bg-warmWhite p-8 md:p-14 rounded-2xl shadow-premium border border-goldAccent/25 reveal-fade-up min-h-[420px] flex flex-col justify-center relative overflow-hidden" id="form-container">
                    
                    <form id="intakeForm" novalidate class="space-y-8 transition-opacity duration-300">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2 group">
                                <label for="fullName" class="text-xs uppercase tracking-wider text-mutedTeal font-bold group-focus-within:text-goldAccent transition-colors">Nombre y apellidos</label>
                                <input type="text" id="fullName" name="fullName" required class="w-full bg-transparent premium-input py-2.5 text-darkTeal focus:outline-none rounded-none text-sm">
                            </div>
                            <div class="space-y-2 group">
                                <label for="patientType" class="text-xs uppercase tracking-wider text-mutedTeal font-bold group-focus-within:text-goldAccent transition-colors">La consulta es para</label>
                                <select id="patientType" name="patientType" required class="w-full bg-transparent premium-input py-2.5 text-darkTeal focus:outline-none appearance-none rounded-none text-sm">
                                    <option value="" disabled selected>Selecciona...</option>
                                    <option value="self">Mí mismo/a</option>
                                    <option value="family">Un familiar</option>
                                </select>
                            </div>
                            <div class="space-y-2 group">
                                <label for="email" class="text-xs uppercase tracking-wider text-mutedTeal font-bold group-focus-within:text-goldAccent transition-colors">Correo electrónico</label>
                                <input type="email" id="email" name="email" required class="w-full bg-transparent premium-input py-2.5 text-darkTeal focus:outline-none rounded-none text-sm">
                            </div>
                            <div class="space-y-2 group">
                                <label for="phone" class="text-xs uppercase tracking-wider text-mutedTeal font-bold group-focus-within:text-goldAccent transition-colors">Teléfono</label>
                                <input type="tel" id="phone" name="phone" required class="w-full bg-transparent premium-input py-2.5 text-darkTeal focus:outline-none rounded-none text-sm">
                            </div>
                        </div>

                        <div class="space-y-8 pt-2">
                            <div class="space-y-2 group">
                                <label for="diagnosis" class="text-xs uppercase tracking-wider text-mutedTeal font-bold group-focus-within:text-goldAccent transition-colors">Diagnóstico principal</label>
                                <input type="text" id="diagnosis" name="diagnosis" required class="w-full bg-transparent premium-input py-2.5 text-darkTeal focus:outline-none rounded-none text-sm">
                            </div>
                            <div class="space-y-2 group">
                                <label for="reason" class="text-xs uppercase tracking-wider text-mutedTeal font-bold group-focus-within:text-goldAccent transition-colors">Motivo de la solicitud</label>
                                <textarea id="reason" name="reason" rows="2" required class="w-full bg-transparent premium-input py-2.5 text-darkTeal focus:outline-none resize-none rounded-none text-sm"></textarea>
                            </div>
                            <div class="space-y-2 group">
                                <label for="question" class="text-xs uppercase tracking-wider text-mutedTeal font-bold group-focus-within:text-goldAccent transition-colors">¿Qué aspecto fundamental te gustaría valorar?</label>
                                <textarea id="question" name="question" rows="2" required class="w-full bg-transparent premium-input py-2.5 text-darkTeal focus:outline-none resize-none rounded-none text-sm"></textarea>
                            </div>
                        </div>

                        <!-- Honeypot anti-bot (Mantiene funcionamiento de solicitudes backend intacto) -->
                        <div class="hidden" aria-hidden="true">
                            <label for="website_url">Website</label>
                            <input type="text" id="website_url" name="website_url" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="pt-2">
                            <label class="flex items-start gap-4 cursor-pointer group">
                                <input type="checkbox" id="privacyConsent" name="privacyConsent" required class="mt-1 appearance-none w-4 h-4 border border-deepTeal/30 rounded-none checked:bg-goldAccent checked:border-goldAccent focus:ring-1 focus:ring-goldAccent transition-all relative">
                                <span class="text-xs text-greyText leading-relaxed">Comprendo que esta solicitud inicia un proceso de evaluación clínica y acepto la política de privacidad aplicable.</span>
                            </label>
                        </div>

                        <div class="pt-6 border-t border-goldAccent/15 flex justify-end">
                            <button type="submit" id="submitBtn" class="px-10 py-4 bg-deepTeal text-warmWhite text-xs uppercase tracking-widest hover:bg-darkTeal transition-all duration-400 focus:outline-none focus:ring-2 focus:ring-goldAccent/50 border border-goldAccent/40 hover:border-goldAccent shadow-lg min-w-[220px] flex items-center justify-center relative overflow-hidden group">
                                <span class="relative z-10">Enviar solicitud</span>
                                <span class="absolute inset-0 bg-goldAccent/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out"></span>
                            </button>
                        </div>
                    </form>

                    <!-- Mensaje de éxito estructurado sin cortes -->
                    <div id="formSuccess" class="hidden flex-col items-center justify-center text-center py-12 px-6 transition-opacity duration-500">
                        <div class="w-16 h-16 border-2 border-goldAccent rounded-full flex items-center justify-center text-goldAccent mb-6 shadow-gold-glow">
                            <i data-lucide="check" class="w-8 h-8 stroke-[1.5]"></i>
                        </div>
                        <h3 class="text-2xl md:text-3xl font-serif text-darkTeal mb-4">Hemos recibido tu solicitud</h3>
                        <p class="text-greyText text-sm md:text-base max-w-md leading-relaxed">El caso será revisado por el equipo médico antes de continuar con el proceso. Nos pondremos en contacto contigo próximamente.</p>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <footer class="bg-darkTeal text-warmWhite pt-20 pb-10 border-t border-goldAccent/20 relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16">
                <div>
                    <strong class="font-serif text-2xl tracking-wide block mb-1">Dr. Juan De la Haba Rodríguez</strong>
                    <span class="text-[10px] uppercase tracking-[0.25em] text-goldAccent font-semibold block mb-6">Oncología Médica</span>
                    <p class="text-sm text-mutedTeal font-light max-w-sm leading-relaxed">Especialización, rigor científico y acompañamiento en procesos oncológicos complejos.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- GSAP & SCROLLTRIGGER SCRIPT -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Inicializar Lucide Icons
        if (window.lucide) lucide.createIcons();

        // Registrar ScrollTrigger de GSAP
        if (window.gsap && window.ScrollTrigger) {
            gsap.registerPlugin(ScrollTrigger);

            // 1. Header shrink on scroll
            ScrollTrigger.create({
                start: 'top -50',
                end: 99999,
                toggleClass: { className: 'h-20', targets: '.header-container' }
            });

            // 2. Revelado Fade Up
            gsap.utils.toArray('.reveal-fade-up').forEach((el) => {
                gsap.fromTo(el, 
                    { opacity: 0, y: 40 },
                    { 
                        opacity: 1, 
                        y: 0, 
                        duration: 1.1, 
                        ease: 'power3.out',
                        scrollTrigger: {
                            trigger: el,
                            start: 'top 88%',
                            toggleActions: 'play none none none'
                        }
                    }
                );
            });

            // 3. Revelado Fade Left
            gsap.utils.toArray('.reveal-fade-left').forEach((el) => {
                gsap.fromTo(el, 
                    { opacity: 0, x: 50 },
                    { 
                        opacity: 1, 
                        x: 0, 
                        duration: 1.2, 
                        ease: 'power3.out',
                        scrollTrigger: {
                            trigger: el,
                            start: 'top 88%',
                            toggleActions: 'play none none none'
                        }
                    }
                );
            });

            // 4. Revelado Fade Right
            gsap.utils.toArray('.reveal-fade-right').forEach((el) => {
                gsap.fromTo(el, 
                    { opacity: 0, x: -50 },
                    { 
                        opacity: 1, 
                        x: 0, 
                        duration: 1.2, 
                        ease: 'power3.out',
                        scrollTrigger: {
                            trigger: el,
                            start: 'top 88%',
                            toggleActions: 'play none none none'
                        }
                    }
                );
            });

            // 5. Revelado Escalonado (Stagger)
            gsap.utils.toArray('.reveal-stagger').forEach((container) => {
                const children = container.children;
                gsap.fromTo(children,
                    { opacity: 0, y: 30 },
                    {
                        opacity: 1,
                        y: 0,
                        duration: 0.8,
                        stagger: 0.12,
                        ease: 'power3.out',
                        scrollTrigger: {
                            trigger: container,
                            start: 'top 85%',
                            toggleActions: 'play none none none'
                        }
                    }
                );
            });
        }

        // LÓGICA DE FORMULARIO - EXACTAMENTE INTACTA
        const intakeForm = document.getElementById('intakeForm');
        const formSuccess = document.getElementById('formSuccess');
        const submitBtn = document.getElementById('submitBtn');

        if (!intakeForm) return;

        intakeForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            // 1. Verificación Honeypot
            const honeypot = document.getElementById('website_url')?.value;
            if (honeypot) return;

            // 2. Obtención de datos
            const fullName = document.getElementById('fullName').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const diagnosis = document.getElementById('diagnosis').value.trim();
            const reason = document.getElementById('reason').value.trim();
            const question = document.getElementById('question').value.trim();
            const privacyConsent = document.getElementById('privacyConsent').checked;

            // 3. Validación previa
            if (!fullName || !email || !phone || !diagnosis || !privacyConsent) {
                alert('Por favor, completa todos los campos obligatorios y acepta la política de privacidad.');
                return;
            }

            // 4. Feedback visual
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = `<span>Procesando...</span>`;

            try {
                // 5. Envío AJAX al endpoint PHP
                const response = await fetch('api.php?action=submit_request', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        action: 'submit_request',
                        fullName: fullName,
                        email: email,
                        phone: phone,
                        diagnosis: diagnosis,
                        reason: reason,
                        question: question
                    })
                });

                const data = await response.json();

                // 6. Manejo de respuesta
                if (data.ok || data.success) {
                    intakeForm.classList.add('opacity-0');
                    setTimeout(() => {
                        intakeForm.style.display = 'none';
                        if (formSuccess) {
                            formSuccess.classList.remove('hidden');
                            formSuccess.classList.add('flex');
                            if (window.lucide) lucide.createIcons();
                        }
                    }, 300);
                } else {
                    alert(data.error || 'Ocurrió un error al procesar la solicitud.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            } catch (error) {
                console.error('Error al conectar con la API:', error);
                alert('Error de conexión con el servidor. Inténtalo de nuevo más tarde.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        });
    });
    </script>
</body>
</html>