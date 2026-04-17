<x-layouts.app :title="__('Validador de Certificados')">
    <div class="max-w-2xl mx-auto space-y-6">

        <div>
            <flux:heading size="xl">Validador de certificados</flux:heading>
            <flux:subheading>Verifica la autenticidad de un certificado mediante su ID único</flux:subheading>
        </div>

        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6">
            <form method="POST" action="{{ route('admin.certificates.check') }}" class="space-y-4">
                @csrf
                <flux:input name="uuid"
                    label="ID del certificado"
                    value="{{ old('uuid', $uuid ?? '') }}"
                    placeholder="Ingresa el ID completo del certificado"
                    required />
                @error('uuid')
                    <p class="text-xs text-red-500 -mt-2">{{ $message }}</p>
                @enderror
                <flux:button type="submit" variant="primary" icon="magnifying-glass">
                    Verificar certificado
                </flux:button>
            </form>
        </div>

        @if($searched)
            @if($certificate)
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-2xl p-6 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/40 flex items-center justify-center">
                            <flux:icon.check-circle class="w-5 h-5 text-green-600 dark:text-green-400" />
                        </div>
                        <div>
                            <p class="font-semibold text-green-700 dark:text-green-400">Certificado válido</p>
                            <p class="text-xs text-green-600 dark:text-green-500">Este certificado es auténtico y fue emitido por Cacao Nativa</p>
                        </div>
                    </div>

                    <div class="border-t border-green-200 dark:border-green-800 pt-4 space-y-3">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide font-medium">Colaborador</p>
                                <p class="font-medium mt-0.5">{{ $certificate->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide font-medium">Correo</p>
                                <p class="font-medium mt-0.5">{{ $certificate->user->email }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide font-medium">Curso</p>
                                <p class="font-medium mt-0.5">{{ $certificate->course->title }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide font-medium">Calificación</p>
                                <p class="font-medium mt-0.5">{{ $certificate->score }}%</p>
                            </div>
                            <div>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide font-medium">Fecha de emisión</p>
                                <p class="font-medium mt-0.5">{{ $certificate->issued_at->translatedFormat('d \d\e F \d\e Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 uppercase tracking-wide font-medium">ID único</p>
                                <p class="font-mono text-xs mt-0.5 text-zinc-600 dark:text-zinc-400 break-all">{{ $certificate->uuid }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl p-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/40 flex items-center justify-center">
                            <flux:icon.x-circle class="w-5 h-5 text-red-600 dark:text-red-400" />
                        </div>
                        <div>
                            <p class="font-semibold text-red-700 dark:text-red-400">Certificado no encontrado</p>
                            <p class="text-xs text-red-600 dark:text-red-500">El ID ingresado no corresponde a ningún certificado emitido por Cacao Nativa</p>
                        </div>
                    </div>
                </div>
            @endif
        @endif

    </div>
</x-layouts.app>