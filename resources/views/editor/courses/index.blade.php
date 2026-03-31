<x-layouts.app :title="__('Gestión de Contenido')">
    <div class="space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">Gestión de Contenido</flux:heading>
                <flux:subheading>Administra los materiales y recursos de aprendizaje</flux:subheading>
            </div>
            <a href="{{ route('editor.courses.create') }}">
                <flux:button variant="primary" icon="plus">Nuevo curso</flux:button>
            </a>
        </div>

        @if(session('success'))
            <div class="px-4 py-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-zinc-100 dark:border-zinc-800">
                        <th class="text-left px-6 py-3 text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Curso / Material</th>
                        <th class="text-left px-6 py-3 text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide hidden md:table-cell">Área</th>
                        <th class="text-left px-6 py-3 text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide hidden md:table-cell">Estatus</th>
                        <th class="text-right px-6 py-3 text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse($courses as $course)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-medium">{{ $course->title }}</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">Por {{ $course->creator->name }}</p>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell text-zinc-600 dark:text-zinc-400">
                                {{ $course->area ?? '—' }}
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                @php
                                    $statusConfig = [
                                        'draft'     => ['label' => 'Borrador',   'class' => 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400'],
                                        'review'    => ['label' => 'En revisión','class' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400'],
                                        'approved'  => ['label' => 'Aprobado',   'class' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400'],
                                        'published' => ['label' => 'Publicado',  'class' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400'],
                                    ];
                                    $config = $statusConfig[$course->status] ?? $statusConfig['draft'];
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $config['class'] }}">
                                    {{ $config['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('editor.courses.edit', $course) }}"
                                       class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                                        Editar
                                    </a>
                                    @if($course->status === 'draft')
                                        <form method="POST" action="{{ route('editor.courses.submit', $course) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                                Enviar a revisión
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-zinc-400 dark:text-zinc-500">
                                No hay cursos aún. Crea el primero.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($courses->hasPages())
                <div class="px-6 py-4 border-t border-zinc-100 dark:border-zinc-800">
                    {{ $courses->links() }}
                </div>
            @endif
        </div>

        {{-- Flujo de publicación --}}
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6">
            <flux:heading size="lg" class="mb-4">Flujo de publicación</flux:heading>
            <div class="flex flex-wrap items-center gap-3">
                @foreach([
                    ['icon' => 'arrow-up-tray', 'label' => 'Recepción',  'sub' => 'Carga de material'],
                    ['icon' => 'eye',            'label' => 'Revisión',   'sub' => 'Validación de contenido'],
                    ['icon' => 'check-circle',   'label' => 'Aprobación', 'sub' => 'Autorización final'],
                    ['icon' => 'globe-alt',      'label' => 'Publicación','sub' => 'Disponible para usuarios'],
                ] as $i => $step)
                    @if($i > 0)
                        <flux:icon.chevron-right class="w-4 h-4 text-zinc-300 dark:text-zinc-600 hidden sm:block" />
                    @endif
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                            <flux:icon :icon="$step['icon']" class="w-4 h-4 text-zinc-500 dark:text-zinc-400" />
                        </div>
                        <div>
                            <p class="text-sm font-medium">{{ $step['label'] }}</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $step['sub'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-layouts.app>