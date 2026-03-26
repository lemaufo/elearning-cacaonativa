<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Usuarios
            'users.view', 'users.create', 'users.edit', 'users.delete',
            // Cursos
            'courses.view', 'courses.create', 'courses.edit',
            'courses.delete', 'courses.publish', 'courses.approve',
            // Evaluaciones
            'quizzes.manage', 'attempts.unlock',
            // Reportes
            'reports.view', 'certificates.view',
            // Configuración
            'settings.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());

        $editor = Role::firstOrCreate(['name' => 'editor']);
        $editor->syncPermissions([
            'courses.view', 'courses.create', 'courses.edit',
            'quizzes.manage', 'certificates.view',
        ]);

        $colaborador = Role::firstOrCreate(['name' => 'colaborador']);
        $colaborador->syncPermissions([
            'courses.view', 'certificates.view',
        ]);
    }
}