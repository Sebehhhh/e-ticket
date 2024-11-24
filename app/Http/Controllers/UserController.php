<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        return view('users.create');
    }

    public function store(Request $request)
{
    if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
    // Validasi input dari form
    // dd($request);
    $request->validate([
        'name' => 'required',
        'username' => 'required|unique:users',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6', // Validasi untuk password
        'isAdmin' => 'required|boolean', // Validasi untuk isAdmin
    ]);

    // Membuat pengguna baru
    User::create([
        'name' => $request->name,
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password), // Hash password sebelum disimpan
        'isAdmin' => $request->isAdmin, // Menyimpan status admin
    ]);

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('users.index')->with('success', 'User  created successfully.');
}

    public function show(User $user)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        // Validasi input dari form
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $id, // Validasi username unik kecuali untuk user ini
            'email' => 'required|email|unique:users,email,' . $id, // Validasi email unik kecuali untuk user ini
            'password' => 'nullable|min:6', // Password opsional, minimal 6 karakter jika diisi
            'isAdmin' => 'required|boolean', // Validasi untuk isAdmin
        ]);
    
        // Ambil user berdasarkan ID
        $user = User::findOrFail($id);
    
        // Update data user
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'isAdmin' => $request->isAdmin,
            'password' => $request->password ? Hash::make($request->password) : $user->password, // Update password hanya jika diisi
        ]);
    
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
    

    public function destroy(User $user)
    {
        if (!Auth::check() || !Auth::user()->isAdmin) {
            return redirect('/home')->with('error', 'You do not have access to this page.');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User  deleted successfully.');
    }
}
