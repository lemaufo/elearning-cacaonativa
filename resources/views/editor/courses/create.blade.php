<x-layouts.app :title="__('Nuevo Curso')">
    <div class="max-w-2xl mx-auto space-y-6">

        <a href="{{ route('editor.courses.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 transition-colors">
            <flux:icon.chevron-left class="w-4 h-4" />
            Volver
        </a>

        <div>
            <flux:heading size="xl">Nuevo curso</flux:heading>
            <flux:subheading>Completa la información básica del curso</flux:subheading>
        </div>

        <form method="POST" action="{{ route('editor.courses.store') }}"
              class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 space-y-5">
            @csrf

            <flux:input
                name="title"
                label="Título del curso"
                value="{{ old('title') }}"
                placeholder="Ej. Seguridad e Higiene en Planta"
                required />
            @error('title')
                <p class="text-xs text-red-500 -mt-3">{{ $message }}</p>
            @enderror

            <div>
                <label class="block text-sm font-medium mb-1.5">Descripción</label>
                <textarea name="description" rows="3"
                          class="w-full px-3 py-2 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-500"
                          placeholder="Descripción breve del curso...">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1.5">Área responsable</label>
                <select name="area"
                        class="w-full px-3 py-2 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-500">
                    <option value="">Selecciona un área</option>
                    @foreach(\App\Models\Area::orderBy('name')->where('active', true)->get() as $area)
                        <option value="{{ $area->name }}" {{ old('area') === $area->name ? 'selected' : '' }}>
                            {{ $area->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('editor.courses.index') }}">
                    <flux:button variant="ghost">Cancelar</flux:button>
                </a>
                <flux:button type="submit" variant="primary">Crear curso</flux:button>
            </div>
        </form>
    </div>
</x-layouts.app>