<x-layouts.app :title="'Evaluación — ' . $course->title">
    <div class="max-w-3xl mx-auto space-y-6">

        <a href="{{ route('cursos.show', $course) }}"
           class="inline-flex items-center gap-1.5 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 transition-colors">
            <flux:icon.chevron-left class="w-4 h-4" />
            Volver al curso
        </a>

        {{-- Header --}}
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <flux:heading size="xl">Evaluación Final</flux:heading>
                    <flux:subheading>{{ $course->title }}</flux:subheading>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Intentos usados</p>
                    <p class="text-2xl font-bold">{{ $attempts }}<span class="text-sm font-normal text-zinc-400"> / {{ $quiz->max_attempts }}</span></p>
                </div>
            </div>

            {{-- Reglas --}}
            <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="flex items-center gap-2 text-sm">
                    <div class="w-5 h-5 rounded-full bg-green-100 dark:bg-green-900/40 flex items-center justify-center flex-shrink-0">
                        <flux:icon.check class="w-3 h-3 text-green-600 dark:text-green-400" />
                    </div>
                    <span class="text-zinc-600 dark:text-zinc-400">Mínimo aprobatorio: <strong>{{ $quiz->min_score }}%</strong></span>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <div class="w-5 h-5 rounded-full bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center flex-shrink-0">
                        <flux:icon.exclamation-triangle class="w-3 h-3 text-amber-600 dark:text-amber-400" />
                    </div>
                    <span class="text-zinc-600 dark:text-zinc-400">Máximo <strong>{{ $quiz->max_attempts }}</strong> intentos</span>
                </div>
                <div class="flex items-center gap-2 text-sm">
                    <div class="w-5 h-5 rounded-full bg-red-100 dark:bg-red-900/40 flex items-center justify-center flex-shrink-0">
                        <flux:icon.x-mark class="w-3 h-3 text-red-600 dark:text-red-400" />
                    </div>
                    <span class="text-zinc-600 dark:text-zinc-400">Bloqueo automático al agotar</span>
                </div>
            </div>

            @if($lastAttempt && !$lastAttempt->passed)
                <div class="mt-4 px-4 py-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl text-sm text-amber-700 dark:text-amber-400">
                    Último intento: <strong>{{ $lastAttempt->score }}%</strong> —
                    Te faltan {{ $quiz->max_attempts - $attempts }} intento(s) más.
                </div>
            @endif
        </div>

        {{-- Formulario --}}
        <form method="POST" action="{{ route('cursos.quiz.submit', $course) }}"
              x-data="{ current: 0, total: {{ $questions->count() }} }"
              class="space-y-4">
            @csrf

            @foreach($questions as $index => $question)
                <div x-show="current === {{ $index }}"
                     class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 space-y-4">

                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">
                            Pregunta {{ $index + 1 }} de {{ $questions->count() }}
                        </span>
                        <div class="flex gap-1">
                            @foreach($questions as $i => $_)
                                <div class="w-2 h-2 rounded-full transition-colors"
                                     :class="current === {{ $i }} ? 'bg-zinc-900 dark:bg-white' : 'bg-zinc-200 dark:bg-zinc-700'">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <p class="text-base font-medium leading-relaxed">{{ $question->question_text }}</p>

                    <div class="space-y-2">
                        @foreach($question->answers as $answer)
                            <label class="flex items-center gap-3 p-3 rounded-xl border border-zinc-200 dark:border-zinc-700 cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors has-[:checked]:border-zinc-900 has-[:checked]:bg-zinc-50 dark:has-[:checked]:border-zinc-400 dark:has-[:checked]:bg-zinc-800">
                                <input type="radio"
                                       name="answers[{{ $question->id }}]"
                                       value="{{ $answer->id }}"
                                       class="w-4 h-4 text-zinc-900 border-zinc-300 focus:ring-zinc-500">
                                <span class="text-sm">{{ $answer->answer_text }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            {{-- Navegación --}}
            <div class="flex items-center justify-between">
                <flux:button type="button" variant="ghost"
                    x-show="current > 0"
                    @click="current--">
                    Anterior
                </flux:button>

                <flux:button type="button" variant="primary"
                    x-show="current < total - 1"
                    @click="current++">
                    Siguiente
                </flux:button>

                <flux:button type="submit" variant="primary"
                    x-show="current === total - 1"
                    onclick="return confirm('¿Estás seguro de enviar tus respuestas?')">
                    Enviar evaluación
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts.app>