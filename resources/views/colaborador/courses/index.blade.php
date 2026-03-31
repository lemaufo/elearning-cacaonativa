<x-layouts.app :title="__('Catálogo de Cursos')">
    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">Catálogo de Cursos</flux:heading>
                <flux:subheading>Accede a todos los cursos disponibles</flux:subheading>
            </div>
        </div>

        {{-- Filtros --}}
        <div x-data="{ filtro: 'todos' }" class="space-y-4">
            <div class="flex flex-wrap gap-2">
                <button @click="filtro = 'todos'"
                    :class="filtro === 'todos' ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'bg-white dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700'"
                    class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors">
                    Todos
                </button>
                <button @click="filtro = 'no_iniciado'"
                    :class="filtro === 'no_iniciado' ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'bg-white dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700'"
                    class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors">
                    No iniciado
                </button>
                <button @click="filtro = 'en_progreso'"
                    :class="filtro === 'en_progreso' ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'bg-white dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700'"
                    class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors">
                    En progreso
                </button>
                <button @click="filtro = 'aprobado'"
                    :class="filtro === 'aprobado' ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900' : 'bg-white dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700'"
                    class="px-4 py-1.5 rounded-full text-sm font-medium transition-colors">
                    Aprobado
                </button>
            </div>

            {{-- Grid de cursos --}}
            @if($courses->isEmpty())
                <div class="text-center py-16">
                    <div class="w-16 h-16 rounded-2xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mx-auto mb-4">
                        <flux:icon.book-open-text class="w-8 h-8 text-zinc-400" />
                    </div>
                    <p class="text-zinc-500 dark:text-zinc-400">No hay cursos disponibles por el momento.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($courses as $course)
                        @php
                            $status = $course->enrollment?->status ?? 'not_started';
                            $alpineStatus = match($status) {
                                'approved'    => 'aprobado',
                                'in_progress' => 'en_progreso',
                                default       => 'no_iniciado',
                            };
                        @endphp

                        <div x-show="filtro === 'todos' || filtro === '{{ $alpineStatus }}'"
                             class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden hover:border-zinc-300 dark:hover:border-zinc-700 transition-colors">

                            {{-- Thumbnail --}}
                            <div class="aspect-video bg-zinc-100 dark:bg-zinc-800 relative">
                                @if($course->thumbnail)
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}"
                                         alt="{{ $course->title }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <flux:icon.book-open-text class="w-10 h-10 text-zinc-300 dark:text-zinc-600" />
                                    </div>
                                @endif

                                {{-- Badge estatus --}}
                                <div class="absolute top-3 left-3">
                                    @if($status === 'approved')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400">
                                            Aprobado
                                        </span>
                                    @elseif($status === 'in_progress')
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400">
                                            En progreso
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                                            No iniciado
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Info --}}
                            <div class="p-4 space-y-3">
                                <div>
                                    <h3 class="font-semibold text-sm leading-tight">{{ $course->title }}</h3>
                                    @if($course->area)
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">{{ $course->area }}</p>
                                    @endif
                                </div>

                                {{-- Progreso --}}
                                @if($course->enrollment)
                                    <div class="space-y-1">
                                        <div class="flex justify-between text-xs text-zinc-500 dark:text-zinc-400">
                                            <span>Progreso</span>
                                            <span>{{ $course->progress_percent }}%</span>
                                        </div>
                                        <div class="h-1.5 bg-zinc-100 dark:bg-zinc-800 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full transition-all duration-300
                                                {{ $status === 'approved' ? 'bg-green-500' : 'bg-blue-500' }}"
                                                style="width: {{ $course->progress_percent }}%">
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- Tipos de contenido --}}
                                @if($course->lessons_count > 0)
                                    <p class="text-xs text-zinc-400 dark:text-zinc-500">
                                        {{ $course->lessons_count }} {{ $course->lessons_count === 1 ? 'lección' : 'lecciones' }}
                                    </p>
                                @endif

                                <a href="{{ route('cursos.show', $course) }}"
                                   class="block w-full text-center py-2 px-4 rounded-xl text-sm font-medium transition-colors
                                          bg-zinc-900 dark:bg-white text-white dark:text-zinc-900
                                          hover:bg-zinc-700 dark:hover:bg-zinc-100">
                                    {{ $course->enrollment ? 'Continuar' : 'Ver curso' }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>