<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-zinc-100 dark:bg-zinc-950">
        <flux:sidebar sticky stashable
            class="border-r border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">

            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            {{-- Logo --}}
            {{-- <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-2 py-1" wire:navigate>
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                     style="background-color: #5C271A">
                    <span class="text-white font-bold text-sm">CN</span>
                </div>
                <div>
                    <p class="font-semibold text-sm leading-tight">Cacao Nativa</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">E-Learning</p>
                </div>
            </a> --}}
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            {{-- Navegación principal --}}
            <flux:navlist variant="outline">
                <flux:navlist.group heading="Principal" class="grid">
                    <flux:navlist.item
                        icon="home"
                        :href="route('dashboard')"
                        :current="request()->routeIs('dashboard')"
                        wire:navigate>
                        Dashboard
                    </flux:navlist.item>

                    <flux:navlist.item
                        icon="book-open-text"
                        :href="route('cursos.index')"
                        :current="request()->routeIs('cursos.index')"
                        wire:navigate>
                        Catálogo de cursos
                    </flux:navlist.item>

                    <flux:navlist.item
                        icon="document-check"
                        :href="route('cursos.certificates')"
                        :current="request()->routeIs('cursos.certificates')"
                        wire:navigate>
                        Mis certificados
                    </flux:navlist.item>
                </flux:navlist.group>

                @if(auth()->user()->hasAnyRole(['admin', 'editor']))
                    <flux:navlist.group heading="Contenido" class="grid">
                        <flux:navlist.item
                            icon="document-text"
                            :href="route('editor.courses.index')"
                            :current="request()->routeIs('editor.*')"
                            wire:navigate>
                            Gestión de contenido
                        </flux:navlist.item>
                    </flux:navlist.group>
                @endif

                @if(auth()->user()->hasRole('admin'))
                    <flux:navlist.group heading="Administración" class="grid">
                        <flux:navlist.item
                            icon="chart-bar"
                            :href="route('admin.dashboard')"
                            :current="request()->routeIs('admin.dashboard')"
                            wire:navigate>
                            Dashboard ejecutivo
                        </flux:navlist.item>

                        <flux:navlist.item
                            icon="users"
                            :href="route('admin.users.index')"
                            :current="request()->routeIs('admin.users.*')"
                            wire:navigate>
                            Usuarios
                        </flux:navlist.item>

                        <flux:navlist.item
                            icon="building-office"
                            :href="route('admin.areas.index')"
                            :current="request()->routeIs('admin.areas.*')"
                            wire:navigate>
                            Áreas
                        </flux:navlist.item>

                        <flux:navlist.item
                            icon="academic-cap"
                            :href="route('admin.courses.index')"
                            :current="request()->routeIs('admin.courses.*')"
                            wire:navigate>
                            Cursos
                        </flux:navlist.item>

                        <flux:navlist.item
                            icon="document-chart-bar"
                            :href="route('admin.reports.index')"
                            :current="request()->routeIs('admin.reports.*')"
                            wire:navigate>
                            Reportes
                        </flux:navlist.item>

                        <flux:navlist.item
                            icon="shield-check"
                            :href="route('admin.certificates.verify')"
                            :current="request()->routeIs('admin.certificates.*')"
                            wire:navigate>
                            Validar certificado
                        </flux:navlist.item>
                    </flux:navlist.group>
                @endif
            </flux:navlist>

            <flux:spacer />

            {{-- Usuario desktop --}}
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>
                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs text-zinc-500">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>
                            Configuración
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit"
                            icon="arrow-right-start-on-rectangle" class="w-full">
                            Cerrar sesión
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        {{-- Mobile header --}}
        <flux:header class="lg:hidden border-b border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            {{-- <div class="flex items-center gap-2 ml-2">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center"
                     style="background-color: #5C271A">
                    <span class="text-white font-bold text-xs">CN</span>
                </div>
                <span class="font-semibold text-sm">Cacao Nativa</span>
            </div> --}}

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />
                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="flex items-center gap-2 px-1 py-1.5 text-sm">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-neutral-200 dark:bg-neutral-700 font-medium">
                                {{ auth()->user()->initials() }}
                            </span>
                            <div>
                                <p class="font-semibold truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-zinc-500 truncate">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    </flux:menu.radio.group>
                    <flux:menu.separator />
                    <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>Configuración</flux:menu.item>
                    <flux:menu.separator />
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit"
                            icon="arrow-right-start-on-rectangle" class="w-full">
                            Cerrar sesión
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>