<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\RegistersUsers;

class AuthController extends Controller
{

    // Menampilkan form pendaftaran
    public function showRegistrationForm()
    {
        return view('register'); // Pastikan Anda memiliki view ini
    }

    // Menangani pendaftaran pengguna
    public function register(Request $request)
    {
        // Validasi input
        $this->validator($request->all())->validate();

        // Buat pengguna baru
        $user = $this->create($request->all());

        // Login pengguna setelah pendaftaran
        auth()->login($user);

        return redirect()->route('home'); // Ganti dengan rute yang sesuai setelah pendaftaran
    }

    // Validasi input
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    // Buat pengguna baru
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'], // Tambahkan ini
            'password' => bcrypt($data['password']),
        ]);
    }

    // Menampilkan form login
    public function showLoginForm()
    {
        return view('login'); // Ganti dengan path view login Anda
    }

   // Proses login
public function login(Request $request)
{
    // Validasi input
    $request->validate([
        'username' => 'required|string', // Ganti 'email' dengan 'username'
        'password' => 'required|string',
    ]);

    // Cek kredensial
    $credentials = $request->only('username', 'password');

    // Mencoba login dengan email atau username
    $user = User::where('email', $request->username)
                ->orWhere('username', $request->username) // Pastikan Anda memiliki kolom 'username' di tabel users
                ->first();

    if ($user && Auth::attempt(['id' => $user->id, 'password' => $request->password])) {
        // Jika berhasil, redirect ke halaman yang diinginkan
        return redirect()->intended('dashboard'); // Ganti dengan route yang sesuai
    }

    // Jika gagal, kembali ke form login dengan pesan error
    return back()->withErrors([
        'username' => 'The provided credentials do not match our records.',
    ]);
}

public function profile()
{
    if (!Auth::check() || !Auth::user()->isAdmin) {
        return redirect('/home')->with('error', 'You do not have access to this page.');
    }
    // Mengambil data pengguna yang sedang terautentikasi
    $user = Auth::user();

    // Mengembalikan view profil dengan data pengguna
    return view('profile.index', compact('user'));
}

public function updateProfile(Request $request)
{
    if (!Auth::check() || !Auth::user()->isAdmin) {
        return redirect('/home')->with('error', 'You do not have access to this page.');
    }

    $user = Auth::user();

    // Validasi data yang diterima untuk profil
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
    ]);

    if ($validator->fails()) {
        return redirect()->route('profile.edit')
                         ->withErrors($validator)
                         ->withInput();
    }

    // Update data pengguna
    $user->name = $request->name;
    $user->username = $request->username;
    $user->email = $request->email;
    $user->save();

    return redirect()->route('profile')->with('success', 'Profile updated successfully!');
}

public function changePassword(Request $request)
{
    if (!Auth::check() || !Auth::user()->isAdmin) {
        return redirect('/home')->with('error', 'You do not have access to this page.');
    }

    $user = Auth::user();

    // Validasi data yang diterima untuk password
    $request->validate([
        'current_password' => 'required|string',
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    // Memeriksa apakah password saat ini benar
    if (!Hash::check($request->current_password, $user->password)) {
        return redirect()->route('profile.edit')->withErrors(['current_password' => 'Current password is incorrect.']);
    }

    // Mengubah password
    $user->password = Hash::make($request->new_password);
    $user->save();

    return redirect()->route('profile')->with('success', 'Password changed successfully!');
}

public function logout(Request $request)
{
    if (!Auth::check() || !Auth::user()->isAdmin) {
        return redirect('/home')->with('error', 'You do not have access to this page.');
    }
    
    Auth::logout();

    // Jika Anda ingin mengalihkan pengguna ke halaman login setelah logout
    return redirect()->route('login')->with('success', 'You have been logged out successfully.');
}
}
