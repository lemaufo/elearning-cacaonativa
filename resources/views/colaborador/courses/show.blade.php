<x-layouts.app :title="$course->title">
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- Back --}}
        <a href="{{ route('cursos.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 transition-colors">
            <flux:icon.arrow-left class="w-4 h-4" />
            Volver al catálogo
        </a>

        @if(session('success'))
            <div class="px-4 py-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Header del curso --}}
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 space-y-4">
            <div class="flex items-start justify-between gap-4">
                <div class="space-y-1">
                    <flux:heading size="xl">{{ $course->title }}</flux:heading>
                    @if($course->area)
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Área: {{ $course->area }}</p>
                    @endif
                </div>

                @if($certificate)
                    <a href="{{ route('cursos.certificate', $course) }}"
                       class="flex-shrink-0 inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium
                              bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-green-400
                              border border-green-200 dark:border-green-800 hover:bg-green-100 transition-colors">
                        <flux:icon.check-circle class="w-4 h-4" />
                        Descargar certificado
                    </a>
                @endif
            </div>

            @if($course->description)
                <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">{{ $course->description }}</p>
            @endif

            {{-- Progreso --}}
            @if($enrollment)
                <div class="space-y-1.5">
                    <div class="flex justify-between text-sm">
                        <span class="text-zinc-500 dark:text-zinc-400">Progreso del curso</span>
                        <span class="font-medium">{{ $progress }}%</span>
                    </div>
                    <div class="h-2 bg-zinc-100 dark:bg-zinc-800 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-500
                            {{ $enrollment->status === 'approved' ? 'bg-green-500' : 'bg-blue-500' }}"
                            style="width: {{ $progress }}%">
                        </div>
                    </div>
                </div>
            @else
                <form method="POST" action="{{ route('cursos.enroll', $course) }}">
                    @csrf
                    <flux:button type="submit" variant="primary" class="w-full sm:w-auto">
                        Inscribirme al curso
                    </flux:button>
                </form>
            @endif
        </div>

        {{-- Lecciones --}}
        @if($lessons->count() > 0)
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800">
                    <flux:heading size="lg">Contenido del curso</flux:heading>
                </div>

                <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @foreach($lessons as $index => $lesson)
                        @php $completed = in_array($lesson->id, $completedLessons); @endphp

                        <div x-data="{ open: false }" class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                {{-- Indicador --}}
                                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0
                                    {{ $completed ? 'bg-green-100 dark:bg-green-900/40' : 'bg-zinc-100 dark:bg-zinc-800' }}">
                                    @if($completed)
                                        <flux:icon.check class="w-4 h-4 text-green-600 dark:text-green-400" />
                                    @else
                                        <span class="text-xs font-medium text-zinc-500">{{ $index + 1 }}</span>
                                    @endif
                                </div>

                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium truncate">{{ $lesson->title }}</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 capitalize">{{ $lesson->type }}</p>
                                </div>

                                {{-- Acciones --}}
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    @if($enrollment && !$completed)
                                        <form method="POST"
                                              action="{{ route('cursos.lessons.complete', [$course, $lesson->id]) }}">
                                            @csrf
                                            <button type="submit"
                                                    class="text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                                Marcar completa
                                            </button>
                                        </form>
                                    @endif

                                    @if($lesson->content_url || $lesson->content_text)
                                        <button @click="open = !open"
                                                class="text-xs text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200">
                                            <span x-text="open ? 'Cerrar' : 'Ver'"></span>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            {{-- Contenido expandible --}}
                            @if($lesson->content_url || $lesson->content_text)
                                <div x-show="open" x-transition class="mt-4 pl-12">
                                    @if($lesson->type === 'video' && $lesson->content_url)
                                        <div class="aspect-video rounded-xl overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                                            <iframe src="{{ $lesson->content_url }}"
                                                    class="w-full h-full"
                                                    allowfullscreen
                                                    frameborder="0">
                                            </iframe>
                                        </div>
                                    @elseif($lesson->type === 'pdf' && $lesson->content_url)
                                        <a href="{{ $lesson->content_url }}"
                                           target="_blank"
                                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm
                                                  bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors">
                                            <flux:icon.document class="w-4 h-4" />
                                            Abrir PDF
                                        </a>
                                    @elseif($lesson->type === 'image' && $lesson->content_url)
                                        <img src="{{ $lesson->content_url }}"
                                             alt="{{ $lesson->title }}"
                                             class="rounded-xl max-w-full">
                                    @elseif($lesson->content_text)
                                        <div class="prose dark:prose-invert text-sm max-w-none">
                                            {!! nl2br(e($lesson->content_text)) !!}
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Quiz --}}
        @if($course->quiz && $enrollment)
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="lg">Evaluación final</flux:heading>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            Calificación mínima: {{ $course->quiz->min_score }}% · Máximo {{ $course->quiz->max_attempts }} intentos
                        </p>
                    </div>
                    @if(!$certificate)
                        <a href="{{ route('cursos.quiz.show', $course) }}">
                            <flux:button variant="primary">Presentar evaluación</flux:button>
                        </a>
                    @else
                        <span class="px-3 py-1.5 rounded-full text-sm font-medium bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400">
                            Aprobado
                        </span>
                    @endif
                </div>
            </div>
        @endif

    </div>
</x-layouts.app>