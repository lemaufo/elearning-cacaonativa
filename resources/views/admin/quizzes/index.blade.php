<x-layouts.app :title="'Evaluación — ' . $course->title">
    <div class="max-w-3xl mx-auto space-y-6">

        <a href="{{ route('admin.courses.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 transition-colors">
            <flux:icon.chevron-left class="w-4 h-4" />
            Volver a cursos
        </a>

        @if(session('success'))
            <div class="px-4 py-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        <flux:heading size="xl">Evaluación — {{ $course->title }}</flux:heading>

        {{-- Configuración del quiz --}}
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6">
            <flux:heading size="lg" class="mb-4">Configuración</flux:heading>

            <form method="POST" action="{{ route('admin.courses.quizzes.store', $course) }}"
                  class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <flux:input name="title" label="Título de la evaluación"
                        value="{{ old('title', $quiz?->title ?? 'Evaluación Final') }}" required />

                    <flux:input name="min_score" label="Calificación mínima (%)"
                        type="number" min="1" max="100"
                        value="{{ old('min_score', $quiz?->min_score ?? 80) }}" required />

                    <flux:input name="max_attempts" label="Máximo de intentos"
                        type="number" min="1" max="10"
                        value="{{ old('max_attempts', $quiz?->max_attempts ?? 3) }}" required />
                </div>

                <flux:button type="submit" variant="primary">
                    {{ $quiz ? 'Actualizar configuración' : 'Crear evaluación' }}
                </flux:button>
            </form>
        </div>

        {{-- Preguntas --}}
        @if($quiz)
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <flux:heading size="lg">Preguntas ({{ $quiz->questions->count() }})</flux:heading>
                </div>

                {{-- Lista de preguntas --}}
                @foreach($quiz->questions as $index => $question)
                    <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-4 space-y-2">
                        <div class="flex items-start justify-between gap-4">
                            <p class="text-sm font-medium">{{ $index + 1 }}. {{ $question->question_text }}</p>
                            <form method="POST" action="{{ route('admin.questions.destroy', $question) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-500 hover:underline flex-shrink-0">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                        <div class="space-y-1 pl-4">
                            @foreach($question->answers as $answer)
                                <div class="flex items-center gap-2 text-xs">
                                    @if($answer->is_correct)
                                        <flux:icon.check-circle class="w-3.5 h-3.5 text-green-500 flex-shrink-0" />
                                    @else
                                        <flux:icon.x-circle class="w-3.5 h-3.5 text-zinc-300 dark:text-zinc-600 flex-shrink-0" />
                                    @endif
                                    <span class="{{ $answer->is_correct ? 'text-green-700 dark:text-green-400 font-medium' : 'text-zinc-500 dark:text-zinc-400' }}">
                                        {{ $answer->answer_text }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                {{-- Agregar pregunta --}}
                <div x-data="{ open: false }" class="pt-2">
                    <button type="button" @click="open = !open"
                            class="inline-flex items-center gap-1.5 text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                        <flux:icon.plus class="w-4 h-4" />
                        Agregar pregunta
                    </button>

                    <div x-show="open" x-transition class="mt-4 border border-zinc-200 dark:border-zinc-700 rounded-xl p-4"
                         x-data="questionForm()">
                        <form method="POST" action="{{ route('admin.quizzes.questions.store', $quiz) }}"
                              class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-sm font-medium mb-1.5">Pregunta</label>
                                <textarea name="question_text" rows="2" required
                                          class="w-full px-3 py-2 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-500"
                                          placeholder="Escribe la pregunta..."></textarea>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium">Respuestas</label>
                                <template x-for="(answer, index) in answers" :key="index">
                                    <div class="flex items-center gap-2">
                                        <input type="radio" name="correct_answer" :value="index"
                                               class="w-4 h-4 text-green-600 border-zinc-300 focus:ring-green-500"
                                               title="Marcar como correcta">
                                        <input type="text" :name="'answers[' + index + '][text]'"
                                               x-model="answer.text" required
                                               class="flex-1 px-3 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-500"
                                               :placeholder="'Respuesta ' + (index + 1)" />
                                        <button type="button" @click="removeAnswer(index)"
                                                x-show="answers.length > 2"
                                                class="text-red-400 hover:text-red-600">
                                            <flux:icon.x-mark class="w-4 h-4" />
                                        </button>
                                    </div>
                                </template>
                                <button type="button" @click="addAnswer()"
                                        class="text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                    + Agregar opción
                                </button>
                                <p class="text-xs text-zinc-400">Selecciona el radio de la respuesta correcta</p>
                            </div>

                            <flux:button type="submit" variant="primary">Guardar pregunta</flux:button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        function questionForm() {
            return {
                answers: [{ text: '' }, { text: '' }, { text: '' }],
                addAnswer() { this.answers.push({ text: '' }); },
                removeAnswer(index) { this.answers.splice(index, 1); }
            }
        }
    </script>
</x-layouts.app>