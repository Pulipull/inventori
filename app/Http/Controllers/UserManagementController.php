<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    private const ROLES = ['guest', 'user', 'admin', 'super_admin'];

    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'role' => ['nullable', Rule::in(self::ROLES)],
            'status' => ['nullable', Rule::in(['active', 'inactive'])],
        ]);

        $users = User::query()
            ->when($filters['search'] ?? null, function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('name', 'like', '%'.$search.'%')
                        ->orWhere('email', 'like', '%'.$search.'%');
                });
            })
            ->when($filters['role'] ?? null, fn ($query, string $role) => $query->where('role', $role))
            ->when(($filters['status'] ?? null) === 'active', fn ($query) => $query->whereRaw('is_active is true'))
            ->when(($filters['status'] ?? null) === 'inactive', fn ($query) => $query->whereRaw('is_active is false'))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $stats = [
            'total' => User::count(),
            'active' => User::whereRaw('is_active is true')->count(),
            'inactive' => User::whereRaw('is_active is false')->count(),
            'super_admin' => User::where('role', 'super_admin')->count(),
        ];

        return view('admin.users.index', [
            'users' => $users,
            'roles' => self::ROLES,
            'stats' => $stats,
        ]);
    }

    public function show(User $user): View
    {
        return view('admin.users.show', [
            'managedUser' => $user,
        ]);
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'managedUser' => $user,
            'roles' => self::ROLES,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'role' => ['required', Rule::in(self::ROLES)],
        ]);

        if ($request->user()->is($user) && $data['role'] !== $user->role) {
            return back()->with('error', 'Anda tidak dapat mengubah role akun yang sedang digunakan.');
        }

        if ($this->wouldDemoteLastSuperAdmin($user, $data['role'])) {
            return back()->with('error', 'Role super admin terakhir tidak dapat dihapus.');
        }

        $user->update(['role' => $data['role']]);

        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'Role user berhasil diperbarui.');
    }

    public function activate(User $user): RedirectResponse
    {
        $user->update(['is_active' => DB::raw('true')]);

        return back()->with('success', 'User berhasil diaktifkan.');
    }

    public function deactivate(User $user): RedirectResponse
    {
        if ($this->wouldDeactivateLastActiveSuperAdmin($user)) {
            return back()->with('error', 'Super admin terakhir tidak dapat dinonaktifkan.');
        }

        $user->update(['is_active' => DB::raw('false')]);

        return back()->with('success', 'User berhasil dinonaktifkan.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($request->user()->is($user)) {
            return back()->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
        }

        if ($this->wouldDeleteLastSuperAdmin($user)) {
            return back()->with('error', 'Super admin terakhir tidak dapat dihapus.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }

    private function wouldDemoteLastSuperAdmin(User $user, string $newRole): bool
    {
        if ($user->role !== 'super_admin' || $newRole === 'super_admin') {
            return false;
        }

        return User::where('role', 'super_admin')->count() <= 1;
    }

    private function wouldDeactivateLastActiveSuperAdmin(User $user): bool
    {
        if ($user->role !== 'super_admin' || ! $user->is_active) {
            return false;
        }

        return User::where('role', 'super_admin')->whereRaw('is_active is true')->count() <= 1;
    }

    private function wouldDeleteLastSuperAdmin(User $user): bool
    {
        if ($user->role !== 'super_admin') {
            return false;
        }

        return User::where('role', 'super_admin')->count() <= 1;
    }
}
