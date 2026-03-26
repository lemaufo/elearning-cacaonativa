<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@cacaonativa.com'],
            [
                'name'     => 'Administrador',
                'password' => Hash::make('Admin1234!'),
                'active'   => true,
                'area'     => null,
            ]
        );
        $admin->assignRole('admin');

        $editor = User::firstOrCreate(
            ['email' => 'editor@cacaonativa.com'],
            [
                'name'     => 'Editor Calidad',
                'password' => Hash::make('Editor1234!'),
                'active'   => true,
                'area'     => 'Calidad',
            ]
        );
        $editor->assignRole('editor');

        $colaborador = User::firstOrCreate(
            ['email' => 'colaborador@cacaonativa.com'],
            [
                'name'                => 'Juan Pérez López',
                'password'            => Hash::make('Colab1234!'),
                'active'              => true,
                'area'                => 'Operaciones',
                'must_change_password' => true,
            ]
        );
        $colaborador->assignRole('colaborador');
    }
}