<x-layouts.app :title="__('Reportes')">
    <div class="space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">Reportes de capacitación</flux:heading>
                <flux:subheading>Seguimiento individual del avance por curso</flux:subheading>
            </div>
            <a href="{{ route('admin.reports.export', request()->query()) }}">
                <flux:button variant="primary" icon="arrow-down-tray">
                    Exportar CSV
                </flux:button>
            </a>
        </div>

        {{-- Filtros --}}
        <form method="GET" action="{{ route('admin.reports.index') }}"
              class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-4">
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <div>
                    <label class="block text-xs font-medium mb-1 text-zinc-500">Colaborador</label>
                    <select name="user_id"
                            class="w-full px-3 py-2 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-500">
                        <option value="">Todos los usuarios</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1 text-zinc-500">Curso</label>
                    <select name="course_id"
                            class="w-full px-3 py-2 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-500">
                        <option value="">Todos los cursos</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1 text-zinc-500">Estatus</label>
                    <select name="status"
                            class="w-full px-3 py-2 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-500">
                        <option value="">Todos los estatus</option>
                        <option value="not_started" {{ request('status') === 'not_started' ? 'selected' : '' }}>No iniciado</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>En progreso</option>
                        <option value="approved"    {{ request('status') === 'approved'    ? 'selected' : '' }}>Aprobado</option>
                        <option value="failed"      {{ request('status') === 'failed'      ? 'selected' : '' }}>Reprobado</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <flux:button type="submit" variant="primary" class="flex-1">Filtrar</flux:button>
                    @if(request()->hasAny(['user_id', 'course_id', 'status']))
                        <a href="{{ route('admin.reports.index') }}">
                            <flux:button variant="ghost">Limpiar</flux:button>
                        </a>
                    @endif
                </div>
            </div>
        </form>

        {{-- Tabla --}}
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-zinc-100 dark:border-zinc-800">
                        <th class="text-left px-6 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wide">Colaborador</th>
                        <th class="text-left px-6 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wide hidden md:table-cell">Curso</th>
                        <th class="text-left px-6 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wide hidden lg:table-cell">Área</th>
                        <th class="text-center px-6 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wide">Estatus</th>
                        <th class="text-left px-6 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wide hidden lg:table-cell">Inscrito</th>
                        <th class="text-left px-6 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wide hidden lg:table-cell">Completado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse($enrollments as $enrollment)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-medium">{{ $enrollment->user->name }}</p>
                                <p class="text-xs text-zinc-500">{{ $enrollment->user->email }}</p>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <p class="font-medium">{{ $enrollment->course->title }}</p>
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell text-zinc-500">
                                {{ $enrollment->user->area ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $statusConfig = [
                                        'not_started' => ['label' => 'No iniciado', 'class' => 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400'],
                                        'in_progress' => ['label' => 'En progreso', 'class' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400'],
                                        'approved'    => ['label' => 'Aprobado',    'class' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400'],
                                        'failed'      => ['label' => 'Reprobado',   'class' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400'],
                                    ];
                                    $sc = $statusConfig[$enrollment->status] ?? $statusConfig['not_started'];
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $sc['class'] }}">
                                    {{ $sc['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell text-zinc-500 text-xs">
                                {{ $enrollment->enrolled_at?->format('d/m/Y') ?? '—' }}
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell text-zinc-500 text-xs">
                                {{ $enrollment->completed_at?->format('d/m/Y') ?? '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-zinc-400">
                                No hay registros con los filtros seleccionados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($enrollments->hasPages())
                <div class="px-6 py-4 border-t border-zinc-100 dark:border-zinc-800">
                    {{ $enrollments->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>