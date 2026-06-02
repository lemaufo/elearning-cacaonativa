<x-layouts.app :title="__('Áreas')">
    <div class="max-w-2xl mx-auto space-y-6">

        <div>
            <flux:heading size="xl">Áreas</flux:heading>
            <flux:subheading>Administra las áreas de la organización</flux:subheading>
        </div>

        @if(session('success'))
            <div class="px-4 py-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.areas.store') }}"
              class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5 flex gap-3">
            @csrf
            <flux:input name="name" placeholder="Nombre del área (ej. Calidad, Operaciones...)" class="flex-1" required />
            <flux:button type="submit" variant="primary">Agregar</flux:button>
        </form>

        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-zinc-100 dark:border-zinc-800">
                        <th class="text-left px-6 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wide">Área</th>
                        <th class="text-right px-6 py-3 text-xs font-medium text-zinc-500 uppercase tracking-wide">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse($areas as $area)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="px-6 py-4 font-medium">{{ $area->name }}</td>
                            <td class="px-6 py-4 text-right">
                                <form method="POST" action="{{ route('admin.areas.destroy', $area) }}"
                                      onsubmit="return confirm('¿Eliminar esta área?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-500 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-8 text-center text-zinc-400">No hay áreas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>