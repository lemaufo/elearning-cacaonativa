<x-layouts.app :title="__('Dashboard Ejecutivo')">
    <div class="space-y-6">

        <div>
            <flux:heading size="xl">Dashboard Ejecutivo</flux:heading>
            <flux:subheading>Seguimiento y control de capacitación</flux:subheading>
        </div>

        {{-- KPIs --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach([
                ['label' => 'Usuarios activos',    'value' => $stats['total_users'],       'color' => 'text-blue-600 dark:text-blue-400'],
                ['label' => 'Cursos publicados',   'value' => $stats['total_courses'],     'color' => 'text-amber-600 dark:text-amber-400'],
                ['label' => 'Certificados emitidos','value' => $stats['total_certs'],      'color' => 'text-green-600 dark:text-green-400'],
                ['label' => 'Promedio aprobación', 'value' => $stats['avg_score'] . '%',  'color' => 'text-purple-600 dark:text-purple-400'],
            ] as $kpi)
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5">
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 font-medium uppercase tracking-wide">{{ $kpi['label'] }}</p>
                    <p class="text-3xl font-bold mt-2 {{ $kpi['color'] }}">{{ $kpi['value'] }}</p>
                </div>
            @endforeach
        </div>

        {{-- Segunda fila de KPIs --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach([
                ['label' => 'En progreso',        'value' => $stats['in_progress']],
                ['label' => 'Completados',         'value' => $stats['approved']],
                ['label' => 'Pendientes revisión', 'value' => $stats['pending_review']],
                ['label' => 'Total inscripciones', 'value' => $stats['total_enrollments']],
            ] as $kpi)
                <div class="bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5">
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 font-medium uppercase tracking-wide">{{ $kpi['label'] }}</p>
                    <p class="text-2xl font-bold mt-2">{{ $kpi['value'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Progreso por curso --}}
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6">
                <flux:heading size="lg" class="mb-4">Avance por curso</flux:heading>
                <div class="space-y-4">
                    @forelse($courseProgress as $course)
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-medium truncate max-w-[60%]">{{ $course->title }}</span>
                                <span class="text-zinc-500 dark:text-zinc-400 text-xs">
                                    {{ $course->approved_count }}/{{ $course->enrollments_count }} completados
                                </span>
                            </div>
                            <div class="h-2 bg-zinc-100 dark:bg-zinc-800 rounded-full overflow-hidden">
                                <div class="h-full bg-amber-500 rounded-full transition-all"
                                     style="width: {{ $course->completion_rate }}%"></div>
                            </div>
                            <p class="text-xs text-zinc-400">{{ $course->completion_rate }}% tasa de aprobación</p>
                        </div>
                    @empty
                        <p class="text-sm text-zinc-400 dark:text-zinc-500">No hay datos aún.</p>
                    @endforelse
                </div>
            </div>

            {{-- Certificados recientes --}}
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6">
                <flux:heading size="lg" class="mb-4">Certificados recientes</flux:heading>
                <div class="space-y-3">
                    @forelse($recentCertificates as $cert)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-green-100 dark:bg-green-900/40 flex items-center justify-center flex-shrink-0">
                                <span class="text-xs font-bold text-green-700 dark:text-green-400">
                                    {{ $cert->user->initials() }}
                                </span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium truncate">{{ $cert->user->name }}</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 truncate">{{ $cert->course->title }}</p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-sm font-bold text-green-600 dark:text-green-400">{{ $cert->score }}%</p>
                                <p class="text-xs text-zinc-400">{{ $cert->issued_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-zinc-400 dark:text-zinc-500">No hay certificados aún.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Tabla de colaboradores --}}
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden">
            <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
                <flux:heading size="lg">Seguimiento por colaborador</flux:heading>
                <a href="{{ route('admin.reports.index') }}">
                    <flux:button variant="ghost" size="sm">Ver reporte completo</flux:button>
                </a>
            </div>
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-zinc-100 dark:border-zinc-800">
                        <th class="text-left px-6 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wide">Colaborador</th>
                        <th class="text-left px-6 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wide hidden md:table-cell">Área</th>
                        <th class="text-center px-6 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wide">Inscritos</th>
                        <th class="text-center px-6 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wide">En progreso</th>
                        <th class="text-center px-6 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wide">Aprobados</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse($userProgress as $user)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-7 h-7 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center flex-shrink-0">
                                        <span class="text-xs font-semibold text-zinc-600 dark:text-zinc-300">
                                            {{ $user->initials() }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ $user->name }}</p>
                                        <p class="text-xs text-zinc-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell text-zinc-500 dark:text-zinc-400">
                                {{ $user->area ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-center font-medium">{{ $user->total_enrollments }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-0.5 rounded-full text-xs bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400">
                                    {{ $user->in_progress }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400">
                                    {{ $user->approved_courses }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-zinc-400">
                                No hay colaboradores registrados aún.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-layouts.app>