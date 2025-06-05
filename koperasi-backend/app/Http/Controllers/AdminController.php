<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->latest()->paginate(10);
        return view('admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admins.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => 'admin',
        ]);

        return redirect()->route('admins.index')
            ->with('success', 'Admin berhasil ditambahkan');
    }

    public function show(User $admin)
    {
        return view('admins.show', compact('admin'));
    }

    public function edit(User $admin)
    {
        return view('admins.edit', compact('admin'));
    }

    public function update(Request $request, User $admin)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($admin->id),
            ],
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except('password');
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admins.index')
            ->with('success', 'Admin berhasil diperbarui');
    }

    public function destroy(User $admin)
    {
        if ($admin->id === auth()->id()) {
            return redirect()->route('admins.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $admin->delete();

        return redirect()->route('admins.index')
            ->with('success', 'Admin berhasil dihapus');
    }

    public function toggleStatus(User $admin)
    {
        $admin->update([
            'is_active' => !$admin->is_active
        ]);

        $status = $admin->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admins.index')
            ->with('success', "Admin berhasil $status");
    }
} 