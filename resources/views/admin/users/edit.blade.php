<x-layouts.app :title="'Editar: ' . $user->name">
    <div class="max-w-2xl mx-auto space-y-6">

        <a href="{{ route('admin.users.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 transition-colors">
            <flux:icon.chevron-left class="w-4 h-4" />
            Volver
        </a>

        @if(session('success'))
            <div class="px-4 py-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        <flux:heading size="xl">Editar usuario</flux:heading>

        <form method="POST" action="{{ route('admin.users.update', $user) }}"
              class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <flux:input name="name" label="Nombre completo"
                    value="{{ old('name', $user->name) }}" required />

                <flux:input name="email" label="Correo electrónico"
                    type="email" value="{{ old('email', $user->email) }}" required />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1.5">Rol</label>
                    <select name="role" required
                            class="w-full px-3 py-2 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-500">
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}"
                                {{ old('role', $user->getRoleNames()->first()) === $role->name ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <flux:input name="area" label="Área"
                    value="{{ old('area', $user->area) }}" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <flux:input name="access_starts_at" label="Acceso desde"
                    type="datetime-local"
                    value="{{ old('access_starts_at', $user->access_starts_at?->format('Y-m-d\TH:i')) }}" />

                <flux:input name="access_ends_at" label="Acceso hasta"
                    type="datetime-local"
                    value="{{ old('access_ends_at', $user->access_ends_at?->format('Y-m-d\TH:i')) }}" />
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="active" id="active" value="1"
                       {{ old('active', $user->active) ? 'checked' : '' }}
                       class="w-4 h-4 rounded border-zinc-300 text-zinc-900 focus:ring-zinc-500">
                <label for="active" class="text-sm font-medium">Usuario activo</label>
            </div>

            <div class="border-t border-zinc-100 dark:border-zinc-800 pt-5">
                <flux:input name="password" label="Nueva contraseña (opcional)"
                    type="password" placeholder="Dejar vacío para no cambiar" />
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('admin.users.index') }}">
                    <flux:button variant="ghost">Cancelar</flux:button>
                </a>
                <flux:button type="submit" variant="primary">Guardar cambios</flux:button>
            </div>
        </form>
    </div>
</x-layouts.app>