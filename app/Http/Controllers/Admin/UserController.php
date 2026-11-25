<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Models\User;
use App\Services\UserIdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Menampilkan daftar user.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Form tambah user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan user baru.
     */
public function store(
    StoreUserRequest $request,
    UserIdGenerator $idGenerator
) {
    User::create([
        'id_user' => $idGenerator->generate(),
        'nama' => $request->nama,
        'username' => $request->username,
        'password' => $request->password,
        'role' => $request->role,
    ]);

    return redirect()
        ->route('admin.users.index')
        ->with('success', 'User berhasil ditambahkan.');
}

    /**
     * Menampilkan detail user.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Form edit user.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user.
     */
    public function update(
        StoreUserRequest $request,
        string $id
    ) {
        $user = User::findOrFail($id);

        $data = [
            'nama' => $request->nama,
            'username' => $request->username,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Menghapus user.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        /*
         * Mencegah admin menghapus akun sendiri.
         */
        if ($user->id_user === auth()->user()->id_user) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}