<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Notification;
use App\Notifications\GenericNotice;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(15);
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::pluck('name','name');
        return view('admin.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'roles' => 'required|array',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_by' => auth()->id(),
        ]);

        $user->syncRoles($request->roles);

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Pengguna Baru',
                    "Pengguna {$user->name} dibuat oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi pengguna: ' . $e->getMessage());
        }

        return redirect()->route('admin.user.index')->with('success', 'Pengguna berhasil dibuat.');
    }

    protected function firstSuperAdminId()
    {
        $first = User::whereHas('roles', function($q){ $q->where('name','Super Admin'); })->orderBy('id')->first();
        return $first ? $first->id : null;
    }

    protected function canEditOrDelete(User $target)
    {
        $me = auth()->user();
        $firstId = $this->firstSuperAdminId();

        // If target is Super Admin
        if ($target->hasRole('Super Admin')) {
            // If I'm the first super admin, allow editing/deleting of users I created and my own account
            if ($me->id === $firstId) {
                // allow editing/deleting, with caution for deleting others: only those I created
                return true;
            }

            // If target is the first super admin => deny for others
            if ($target->id === $firstId) {
                return false;
            }

            // Other super admins (not first) cannot edit/delete other super admins
            return false;
        }

        // For non-superadmins: allow if I have Super Admin role or Staff as appropriate
        // Only Super Admin/Staff with admin middleware reach here, so allow
        return true;
    }

    public function edit(User $user)
    {
        if (! $this->canEditOrDelete($user)) {
            return redirect()->route('admin.user.index')->with('error', 'Anda tidak memiliki izin untuk mengedit akun ini.');
        }

        $roles = Role::pluck('name','name');
        return view('admin.user.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        if (! $this->canEditOrDelete($user)) {
            return redirect()->route('admin.user.index')->with('error', 'Anda tidak memiliki izin untuk mengubah akun ini.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:6|confirmed',
            'roles' => 'required|array',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $user->syncRoles($request->roles);

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Pengguna Diperbarui',
                    "Pengguna {$user->name} diperbarui oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi update pengguna: ' . $e->getMessage());
        }

        return redirect()->route('admin.user.index')->with('success', 'Pengguna berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        if (! $this->canEditOrDelete($user)) {
            return redirect()->route('admin.user.index')->with('error', 'Anda tidak memiliki izin untuk menghapus akun ini.');
        }

        $me = auth()->user();
        $firstId = $this->firstSuperAdminId();

        // If target is super admin and I'm the first: only allow deletion of those I created
        if ($user->hasRole('Super Admin') && $me->id === $firstId) {
            if ($user->created_by !== $me->id && $user->id !== $me->id) {
                return redirect()->route('admin.user.index')->with('error', 'Anda hanya dapat menghapus super admin yang Anda buat.');
            }
        }

        $name = $user->name;
        $user->delete();

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Pengguna Dihapus',
                    "Pengguna {$name} dihapus oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi hapus pengguna: ' . $e->getMessage());
        }

        return redirect()->route('admin.user.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}