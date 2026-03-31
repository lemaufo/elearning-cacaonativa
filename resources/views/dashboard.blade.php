<x-layouts.app :title="__('Dashboard')">
    <div class="space-y-6">

        <div>
            <flux:heading size="xl">Bienvenido, {{ auth()->user()->name }}</flux:heading>
            <flux:subheading>{{ now()->translatedFormat('l, d \d\e F \d\e Y') }}</flux:subheading>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5">
                <p class="text-xs text-zinc-500 dark:text-zinc-400 font-medium uppercase tracking-wide">Cursos disponibles</p>
                <p class="text-3xl font-bold mt-2">{{ \App\Models\Course::where('status','published')->count() }}</p>
            </div>
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5">
                <p class="text-xs text-zinc-500 dark:text-zinc-400 font-medium uppercase tracking-wide">En progreso</p>
                <p class="text-3xl font-bold mt-2">{{ auth()->user()->enrollments()->where('status','in_progress')->count() }}</p>
            </div>
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5">
                <p class="text-xs text-zinc-500 dark:text-zinc-400 font-medium uppercase tracking-wide">Completados</p>
                <p class="text-3xl font-bold mt-2">{{ auth()->user()->enrollments()->where('status','approved')->count() }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 text-center">
            <div class="w-14 h-14 rounded-2xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mx-auto mb-4">
                <flux:icon.book-open-text class="w-7 h-7 text-zinc-400" />
            </div>
            <flux:heading size="lg">Explora el catálogo de cursos</flux:heading>
            <flux:subheading class="mt-1 mb-4">Encuentra los cursos disponibles para tu área</flux:subheading>
            <a href="{{ route('cursos.index') }}">
                <flux:button variant="primary">Ver catálogo</flux:button>
            </a>
        </div>

    </div>
</x-layouts.app>