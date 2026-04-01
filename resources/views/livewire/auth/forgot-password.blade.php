<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        Password::sendResetLink($this->only('email'));

        session()->flash('status', __('Se enviará un enlace de restablecimiento si la cuenta existe.'));
    }
}; ?>

<div class="flex flex-col gap-6">
    <x-auth-header title="Restablecer contraseña" description="Ingresa tu correo electrónico para recibir un enlace de restablecimiento de contraseña" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="flex flex-col gap-6">
        <!-- Email Address -->
        <div class="grid gap-2">
            <flux:input wire:model="email" label="{{ __('Correo electrónico') }}" type="email" name="email" required autofocus placeholder="correo@ejemplo.com" />
        </div>

        <flux:button variant="primary" type="submit" class="w-full">{{ __('Enviar enlace de restablecimiento') }}</flux:button>
    </form>

    <div class="space-x-1 text-center text-sm text-zinc-400">
        O si recuerdas tu contraseña puedes
        <x-text-link href="{{ route('login') }}">iniciar sesión</x-text-link>
    </div>
</div>
