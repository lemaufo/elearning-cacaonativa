<x-layouts.app :title="__('Nuevo Usuario')">
    <div class="max-w-2xl mx-auto space-y-6">

        <a href="{{ route('admin.users.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-200 transition-colors">
            <flux:icon.chevron-left class="w-4 h-4" />
            Volver
        </a>

        <div>
            <flux:heading size="xl">Nuevo usuario</flux:heading>
            <flux:subheading>El usuario deberá cambiar su contraseña en el primer inicio de sesión</flux:subheading>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}"
              class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <flux:input name="name" label="Nombre completo"
                    value="{{ old('name') }}" required
                    placeholder="Juan Pérez López" />

                <flux:input name="email" label="Correo electrónico"
                    type="email" value="{{ old('email') }}" required
                    placeholder="usuario@cacaonativa.com" />
            </div>

            @error('name') <p class="text-xs text-red-500 -mt-3">{{ $message }}</p> @enderror
            @error('email') <p class="text-xs text-red-500 -mt-3">{{ $message }}</p> @enderror

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <flux:input name="password" label="Contraseña temporal"
                    type="password" required placeholder="Mínimo 8 caracteres" />

                <div>
                    <label class="block text-sm font-medium mb-1.5">Rol</label>
                    <select name="role" required
                            class="w-full px-3 py-2 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-sm focus:outline-none focus:ring-2 focus:ring-zinc-500">
                        <option value="">Selecciona un rol</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <flux:input name="area" label="Área"
                value="{{ old('area') }}"
                placeholder="Ej. Calidad, Operaciones, RR.HH." />

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <flux:input name="access_starts_at" label="Acceso desde"
                    type="datetime-local" value="{{ old('access_starts_at') }}" />

                <flux:input name="access_ends_at" label="Acceso hasta"
                    type="datetime-local" value="{{ old('access_ends_at') }}" />
            </div>

            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                Deja las fechas vacías para acceso sin restricción de tiempo.
            </p>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('admin.users.index') }}">
                    <flux:button variant="ghost">Cancelar</flux:button>
                </a>
                <flux:button type="submit" variant="primary">Crear usuario</flux:button>
            </div>
        </form>
    </div>
</x-layouts.app>