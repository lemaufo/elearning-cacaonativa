<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);

        $users = User::with('roles')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);
        $roles = Role::all();
        $areas = \App\Models\Area::orderBy('name')->where('active', true)->get();
        return view('admin.users.create', compact('roles', 'areas'));
    }

    public function store(Request $request)
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|min:8',
            'role'             => 'required|exists:roles,name',
            'areas'            => 'nullable|array',
            'areas.*'          => 'exists:areas,id',
            'access_starts_at' => 'nullable|date',
            'access_ends_at'   => 'nullable|date|after_or_equal:access_starts_at',
        ]);

        $user = User::create([
            'name'                 => $validated['name'],
            'email'                => $validated['email'],
            'password'             => Hash::make($validated['password']),
            'active'               => true,
            'must_change_password' => true,
            'access_starts_at'     => $validated['access_starts_at'] ?? null,
            'access_ends_at'       => $validated['access_ends_at'] ?? null,
        ]);

        $user->assignRole($validated['role']);
        $user->areas()->sync($request->areas ?? []);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $user)
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);
        $roles = Role::all();
        $areas = \App\Models\Area::orderBy('name')->where('active', true)->get();
        return view('admin.users.edit', compact('user', 'roles', 'areas'));
    }

    public function update(Request $request, User $user)
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email,' . $user->id,
            'role'             => 'required|exists:roles,name',
            'areas'            => 'nullable|array',
            'areas.*'          => 'exists:areas,id',
            'active'           => 'boolean',
            'access_starts_at' => 'nullable|date',
            'access_ends_at'   => 'nullable|date|after_or_equal:access_starts_at',
        ]);

        $user->update([
            'name'             => $validated['name'],
            'email'            => $validated['email'],
            'active'           => $request->boolean('active'),
            'access_starts_at' => $validated['access_starts_at'] ?? null,
            'access_ends_at'   => $validated['access_ends_at'] ?? null,
        ]);

        $user->syncRoles([$validated['role']]);
        $user->areas()->sync($request->areas ?? []);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8']);
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);
        abort_if($user->id === Auth::id(), 403);

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado.');
    }
}