<!DOCTYPE html>
<html lang="es" class="{{ Cookie::get('flux_appearance') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cacao Nativa E-Learning</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 font-sans antialiased relative">
    {{-- Fondo cuadrícula --}}
    <div class="fixed inset-0 pointer-events-none" aria-hidden="true"
        style="
            background-image:
                linear-gradient(to right, rgba(82,39,26,0.06) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(72,29,16,0.06) 1px, transparent 1px);
            background-size: 40px 40px;
        ">
    </div>
    <div class="fixed inset-0 pointer-events-none dark:block hidden" aria-hidden="true"
        style="
            background-image:
                linear-gradient(to right, rgba(255,255,255,0.04) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 40px 40px;
        ">
    </div>
    
    {{-- Navbar --}}
    <nav class="sticky top-0 z-50 bg-white/90 dark:bg-zinc-950/90 backdrop-blur border-b border-zinc-200 dark:border-zinc-800">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-14 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-3">
                    <div class="flex aspect-square size-12 items-center justify-center rounded-md">
                        <x-app-logo-icon class="size-8 fill-current text-white" />
                    </div>
                    <div>
                        <p class="font-semibold text-sm leading-tight">Cacao Nativa</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 leading-tight">Plataforma E-Learning</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium text-white transition-colors"
                       style="background:#5C271A">
                        Ir al dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium text-white transition-colors"
                       style="background:#5C271A">
                        Iniciar sesión
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 py-20 text-center">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border text-xs font-medium mb-6"
             style="background:#FAF0EB; border-color:#E8C5B5; color:#5C271A">
            <i class="ti ti-award" aria-hidden="true"></i>
            Plataforma corporativa de capacitación
        </div>
        <h1 class="text-4xl sm:text-5xl font-semibold leading-tight max-w-2xl mx-auto mb-5">
            Capacitación digital para tu equipo,
            <span style="color:#5C271A">en un solo lugar</span>
        </h1>
        <p class="text-zinc-500 dark:text-zinc-400 text-lg max-w-xl mx-auto mb-8 leading-relaxed">
            Gestiona cursos, evalúa competencias y emite certificados de forma automática. Todo bajo la identidad de Cacao Nativa.
        </p>
        <div class="flex items-center justify-center gap-3 flex-wrap">
            @auth
                <a href="{{ url('/dashboard') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-medium text-white transition-colors"
                   style="background:#5C271A">
                    Ir a la plataforma <i class="ti ti-arrow-right" aria-hidden="true"></i>
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-medium text-white transition-colors"
                   style="background:#5C271A">
                    Acceder a la plataforma <i class="ti ti-arrow-right" aria-hidden="true"></i>
                </a>
            @endauth
            {{-- <a href="#como-funciona"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-medium border border-zinc-200 dark:border-zinc-700 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-900 transition-colors">
                <i class="ti ti-player-play" aria-hidden="true"></i> Cómo funciona
            </a> --}}
        </div>
    </section>

    {{-- Stats --}}
    {{-- <div class="border-y border-zinc-200 dark:border-zinc-800">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-3 divide-x divide-zinc-200 dark:divide-zinc-800">
                @foreach([
                    ['val' => '100%', 'lbl' => 'Digital y sin papel'],
                    ['val' => '3',    'lbl' => 'Roles especializados'],
                    ['val' => '∞',   'lbl' => 'Cursos ilimitados'],
                ] as $stat)
                    <div class="py-8 text-center">
                        <p class="text-3xl font-semibold" style="color:#5C271A">{{ $stat['val'] }}</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">{{ $stat['lbl'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div> --}}

    {{-- Features --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 py-10">
        <p class="text-xs font-medium tracking-widest uppercase text-zinc-400 dark:text-zinc-500 mb-2">Funcionalidades</p>
        <h2 class="text-2xl font-semibold mb-10">Todo lo que necesitas para capacitar a tu equipo</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach([
                ['icon' => 'ti-book',           'bg' => '#FAF0EB', 'color' => '#5C271A', 'title' => 'Catálogo de cursos',       'desc' => 'Video, PDF, imágenes y texto. Contenido ilimitado organizado por área responsable.'],
                ['icon' => 'ti-clipboard-check', 'bg' => '#E8F0ED', 'color' => '#1D483B', 'title' => 'Evaluaciones automáticas', 'desc' => 'Exámenes con calificación mínima, límite de intentos y bloqueo automático.'],
                ['icon' => 'ti-certificate',    'bg' => '#E8EFF5', 'color' => '#18405D', 'title' => 'Certificados PDF',          'desc' => 'Emisión automática al aprobar, con sello institucional y validación por UUID.'],
                ['icon' => 'ti-chart-bar',      'bg' => '#F5EDE8', 'color' => '#7F5E43', 'title' => 'Dashboard ejecutivo',       'desc' => 'KPIs en tiempo real, seguimiento por colaborador y exportación de reportes.'],
            ] as $feat)
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center mb-4"
                         style="background:{{ $feat['bg'] }}">
                        <i class="ti {{ $feat['icon'] }} text-lg" style="color:{{ $feat['color'] }}" aria-hidden="true"></i>
                    </div>
                    <p class="font-medium text-sm mb-1">{{ $feat['title'] }}</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 leading-relaxed">{{ $feat['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Flujo --}}
    <section id="como-funciona" class="border-t border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-20">
            <p class="text-xs font-medium tracking-widest uppercase text-zinc-400 dark:text-zinc-500 mb-2">Flujo de trabajo</p>
            <h2 class="text-2xl font-semibold mb-10">De la creación a la certificación</h2>
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
                @foreach([
                    ['num' => '1', 'title' => 'Carga',        'sub' => 'Editor sube el contenido',    'active' => true],
                    ['num' => '2', 'title' => 'Revisión',      'sub' => 'Validación editorial',        'active' => false],
                    ['num' => '3', 'title' => 'Publicación',   'sub' => 'Admin aprueba el curso',      'active' => false],
                    ['num' => '4', 'title' => 'Capacitación',  'sub' => 'Colaborador aprende',         'active' => false],
                    ['num' => '5', 'title' => 'Certificado',   'sub' => 'Emisión automática PDF',      'active' => false],
                ] as $step)
                    <div class="text-center">
                        <div class="w-10 h-10 rounded-full mx-auto mb-3 flex items-center justify-center text-sm font-medium border
                            {{ $step['active']
                                ? 'text-white border-transparent'
                                : 'text-zinc-500 dark:text-zinc-400 border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900' }}"
                             style="{{ $step['active'] ? 'background:#5C271A' : '' }}">
                            {{ $step['num'] }}
                        </div>
                        <p class="text-sm font-medium">{{ $step['title'] }}</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 leading-tight">{{ $step['sub'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Roles --}}
    {{-- <section class="max-w-6xl mx-auto px-4 sm:px-6 py-20">
        <p class="text-xs font-medium tracking-widest uppercase text-zinc-400 dark:text-zinc-500 mb-2">Accesos</p>
        <h2 class="text-2xl font-semibold mb-10">Tres roles, un solo sistema</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            @foreach([
                ['color' => '#5C271A', 'role' => 'Administrador', 'items' => ['Gestión total de usuarios', 'Publicación de cursos', 'Dashboard ejecutivo', 'Reportes y exportación CSV', 'Validador de certificados']],
                ['color' => '#1D483B', 'role' => 'Editor de área', 'items' => ['Crear y editar cursos', 'Cargar lecciones y recursos', 'Enviar a revisión', 'Gestionar contenido de su área']],
                ['color' => '#18405D', 'role' => 'Colaborador',    'items' => ['Acceso al catálogo de cursos', 'Progreso por lección', 'Evaluaciones y exámenes', 'Descarga de certificados PDF']],
            ] as $rol)
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background:{{ $rol['color'] }}"></div>
                        <p class="font-medium text-sm">{{ $rol['role'] }}</p>
                    </div>
                    <ul class="space-y-2">
                        @foreach($rol['items'] as $item)
                            <li class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                                <div class="w-1 h-1 rounded-full bg-zinc-300 dark:bg-zinc-600 flex-shrink-0"></div>
                                {{ $item }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </section> --}}

    {{-- CTA --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 pb-20">
        <div class="rounded-2xl p-10 text-center" style="background:#1D483B">
            <h2 class="text-2xl font-semibold mb-2" style="color:#ACE7D3">Listo para capacitar a tu equipo</h2>
            <p class="text-sm mb-6" style="color:#7FB8A8">Accede a la plataforma y comienza hoy mismo.</p>
            @auth
                <a href="{{ url('/dashboard') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-medium transition-colors"
                   style="background:#FAF7F2; color:#1D483B">
                    Ir a la plataforma <i class="ti ti-arrow-right" aria-hidden="true"></i>
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-medium transition-colors"
                   style="background:#FAF7F2; color:#1D483B">
                    Iniciar sesión <i class="ti ti-arrow-right" aria-hidden="true"></i>
                </a>
            @endauth
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-zinc-200 dark:border-zinc-800">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-5 flex items-center justify-between flex-wrap gap-3">
            <p class="text-xs text-zinc-400 dark:text-zinc-500">© {{ date('Y') }} Cacao Nativa · Todos los derechos reservados</p>
            <p class="text-xs text-zinc-400 dark:text-zinc-500">
                Desarrollado por <span class="font-medium" style="color:#5C271A">Teknologix</span>
            </p>
        </div>
    </footer>

</body>
</html>