<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        abort_unless(auth()->user()->isSuperAdmin(), 403);
        $users = User::query()->orderBy('name')->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request, ActivityLogger $logger): RedirectResponse
    {
        abort_unless(auth()->user()->isSuperAdmin(), 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:admin,super_admin'],
        ]);

        $user = User::query()->create([
            ...$data,
            'password' => Hash::make($data['password']),
        ]);
        $logger->log('user.created', $user);

        return back()->with('success', 'User created.');
    }

    public function update(Request $request, User $user, ActivityLogger $logger): RedirectResponse
    {
        abort_unless(auth()->user()->isSuperAdmin(), 403);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', 'in:admin,super_admin'],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->role = $data['role'];
        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();
        $logger->log('user.updated', $user);

        return back()->with('success', 'User updated.');
    }

    public function destroy(User $user, ActivityLogger $logger): RedirectResponse
    {
        abort_unless(auth()->user()->isSuperAdmin(), 403);
        abort_if($user->id === auth()->id(), 400, 'Cannot delete yourself.');

        $logger->log('user.deleted', $user);
        $user->delete();

        return back()->with('success', 'User deleted.');
    }
}
