<x-layouts.app :title="__('Usuarios')">
    <div class="space-y-6">

        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">Usuarios</flux:heading>
                <flux:subheading>Gestiona los accesos a la plataforma</flux:subheading>
            </div>
            <a href="{{ route('admin.users.create') }}">
                <flux:button variant="primary" icon="plus">Nuevo usuario</flux:button>
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
                        <th class="text-left px-6 py-3 text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Usuario</th>
                        <th class="text-left px-6 py-3 text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide hidden md:table-cell">Rol</th>
                        <th class="text-left px-6 py-3 text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide hidden lg:table-cell">Área</th>
                        <th class="text-left px-6 py-3 text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide hidden lg:table-cell">Estatus</th>
                        <th class="text-right px-6 py-3 text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse($users as $user)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center flex-shrink-0">
                                        <span class="text-xs font-semibold text-zinc-600 dark:text-zinc-300">
                                            {{ $user->initials() }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ $user->name }}</p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400 capitalize">
                                    {{ $user->getRoleNames()->first() ?? '—' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell text-zinc-600 dark:text-zinc-400">
                                {{ $user->area ?? '—' }}
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell">
                                @if($user->active)
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400">
                                        Activo
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400">
                                        Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors">
                                        Editar
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                              onsubmit="return confirm('¿Eliminar este usuario?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-sm text-red-500 hover:underline">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-zinc-400 dark:text-zinc-500">
                                No hay usuarios registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-zinc-100 dark:border-zinc-800">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>