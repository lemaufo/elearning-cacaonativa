<x-layouts.app :title="'Editar: ' . $course->title">
    <div class="max-w-3xl mx-auto space-y-6">

        <a href="{{ route('editor.courses.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 transition-colors">
            <flux:icon.chevron-left class="w-4 h-4" />
            Volver
        </a>

        @if(session('success'))
            <div class="px-4 py-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex items-start justify-between gap-4">
            <div>
                <flux:heading size="xl">{{ $course->title }}</flux:heading>
                <flux:subheading>Edita el contenido y las lecciones del curso</flux:subheading>
            </div>
            @php
                $statusConfig = [
                    'draft'     => ['label' => 'Borrador',    'class' => 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400'],
                    'review'    => ['label' => 'En revisión', 'class' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400'],
                    'approved'  => ['label' => 'Aprobado',    'class' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400'],
                    'published' => ['label' => 'Publicado',   'class' => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400'],
                ];
                $config = $statusConfig[$course->status];
            @endphp
            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $config['class'] }}">
                {{ $config['label'] }}
            </span>
        </div>

        <form method="POST" action="{{ route('editor.courses.update', $course) }}"
              x-data="lessonManager(@js($lessons))"
              class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Info básica --}}
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 space-y-5">
                <flux:heading size="lg">Información general</flux:heading>

                <flux:input name="title" label="Título" value="{{ old('title', $course->title) }}" required />

                <div>
                    <label class="block text-sm font-medium mb-1.5">Descripción</label>
                    <textarea name="description" rows="3"
                              class="w-full px-3 py-2 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-500">{{ old('description', $course->description) }}</textarea>
                </div>

                <flux:input name="area" label="Área responsable" value="{{ old('area', $course->area) }}" />
            </div>

            {{-- Lecciones --}}
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <flux:heading size="lg">Lecciones</flux:heading>
                    <button type="button" @click="addLesson()"
                            class="inline-flex items-center gap-1.5 text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                        <flux:icon.plus class="w-4 h-4" />
                        Agregar lección
                    </button>
                </div>

                <div class="space-y-4">
                    <template x-for="(lesson, index) in lessons" :key="index">
                        <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-4 space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400"
                                      x-text="'Lección ' + (index + 1)"></span>
                                <button type="button" @click="removeLesson(index)"
                                        class="text-xs text-red-500 hover:underline">
                                    Eliminar
                                </button>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium mb-1">Título</label>
                                    <input type="text"
                                           :name="'lessons[' + index + '][title]'"
                                           x-model="lesson.title"
                                           class="w-full px-3 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-500"
                                           placeholder="Título de la lección" />
                                </div>
                                <div>
                                    <label class="block text-xs font-medium mb-1">Tipo</label>
                                    <select :name="'lessons[' + index + '][type]'"
                                            x-model="lesson.type"
                                            class="w-full px-3 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-500">
                                        <option value="video">Video</option>
                                        <option value="pdf">PDF</option>
                                        <option value="image">Imagen</option>
                                        <option value="text">Texto</option>
                                    </select>
                                </div>
                            </div>

                            <div x-show="lesson.type !== 'text'">
                                <label class="block text-xs font-medium mb-1">URL del contenido</label>
                                <input type="url"
                                       :name="'lessons[' + index + '][content_url]'"
                                       x-model="lesson.content_url"
                                       class="w-full px-3 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-500"
                                       placeholder="https://..." />
                            </div>

                            <div x-show="lesson.type === 'text'">
                                <label class="block text-xs font-medium mb-1">Contenido</label>
                                <textarea :name="'lessons[' + index + '][content_text]'"
                                          x-model="lesson.content_text"
                                          rows="3"
                                          class="w-full px-3 py-2 rounded-lg border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-500"
                                          placeholder="Escribe el contenido..."></textarea>
                            </div>
                        </div>
                    </template>

                    <div x-show="lessons.length === 0"
                         class="text-center py-8 text-sm text-zinc-400 dark:text-zinc-500">
                        No hay lecciones. Agrega la primera.
                    </div>
                </div>
            </div>

            {{-- Acciones --}}
            <div class="flex items-center justify-between">
                <div class="flex gap-3">
                    @if($course->status === 'draft')
                        <form method="POST" action="{{ route('editor.courses.submit', $course) }}">
                            @csrf
                            @method('PATCH')
                            <flux:button type="submit" variant="ghost">
                                Enviar a revisión
                            </flux:button>
                        </form>
                    @endif
                </div>
                <flux:button type="submit" variant="primary">Guardar cambios</flux:button>
            </div>
        </form>
    </div>

    <script>
        function lessonManager(initialLessons) {
            return {
                lessons: initialLessons.length > 0 ? initialLessons : [],
                addLesson() {
                    this.lessons.push({
                        title: '',
                        type: 'video',
                        content_url: '',
                        content_text: '',
                        description: '',
                    });
                },
                removeLesson(index) {
                    this.lessons.splice(index, 1);
                }
            }
        }
    </script>
</x-layouts.app>