<x-layouts.app :title="__('Mis Certificados')">
    <div class="space-y-6">

        <div>
            <flux:heading size="xl">Mis Certificados</flux:heading>
            <flux:subheading>Historial de cursos completados y certificaciones obtenidas</flux:subheading>
        </div>

        @if(session('success'))
            <div class="px-4 py-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($certificates->isEmpty())
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-12 text-center">
                <div class="w-16 h-16 rounded-2xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mx-auto mb-4">
                    <flux:icon.document class="w-8 h-8 text-zinc-400" />
                </div>
                <flux:heading size="lg">Sin certificados aún</flux:heading>
                <flux:subheading class="mt-1 mb-4">Completa y aprueba un curso para obtener tu primer certificado</flux:subheading>
                <a href="{{ route('cursos.index') }}">
                    <flux:button variant="primary">Ver catálogo de cursos</flux:button>
                </a>
            </div>
        @else
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-zinc-100 dark:border-zinc-800">
                            <th class="text-left px-6 py-3 text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">ID</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Curso</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide hidden md:table-cell">Calificación</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide hidden md:table-cell">Fecha</th>
                            <th class="text-right px-6 py-3 text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @foreach($certificates as $certificate)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-mono text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ substr($certificate->uuid, 0, 8) }}...
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-green-100 dark:bg-green-900/40 flex items-center justify-center flex-shrink-0">
                                            <flux:icon.check-circle class="w-4 h-4 text-green-600 dark:text-green-400" />
                                        </div>
                                        <div>
                                            <p class="font-medium">{{ $certificate->course->title }}</p>
                                            @if($certificate->course->area)
                                                <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $certificate->course->area }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 hidden md:table-cell">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400">
                                        {{ $certificate->score }}%
                                    </span>
                                </td>
                                <td class="px-6 py-4 hidden md:table-cell text-zinc-500 dark:text-zinc-400 text-xs">
                                    {{ $certificate->issued_at->translatedFormat('d \d\e F \d\e Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('cursos.certificate', $certificate->course) }}"
                                       class="inline-flex items-center gap-1.5 text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                        <flux:icon.arrow-down-tray class="w-4 h-4" />
                                        Descargar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <p class="text-xs text-zinc-400 dark:text-zinc-500 text-center">
                {{ $certificates->count() }} {{ $certificates->count() === 1 ? 'certificado obtenido' : 'certificados obtenidos' }}
            </p>
        @endif
    </div>
</x-layouts.app>