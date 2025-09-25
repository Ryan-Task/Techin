<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyAccountMail;

class UserController extends Controller
{
    // Tampilkan daftar akun
    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::when($search, function($query, $search) {
                return $query->where('name', 'like', "%$search%")
                             ->orWhere('email', 'like', "%$search%");
            })
            ->paginate(10);

        return view('page.pemilik.akun', compact('users', 'search'));
    }

    // Tambah akun baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:teknisi,owner',
            'no_wa' => 'nullable|string|max:20',
        ]);

        // Buat kode verifikasi 6 digit
        $verification_code = mt_rand(100000, 999999);

        // Simpan user baru beserta kode verifikasi
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'akses' => false, // nonaktif sampai diverifikasi
            'no_wa' => $request->no_wa,
            'verification_code' => $verification_code,
        ]);

        // Kirim email verifikasi
        Mail::to($user->email)->send(new VerifyAccountMail($user));

        // Response untuk AJAX
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Akun berhasil ditambahkan. Kode verifikasi telah dikirim ke email.',
                'user_id' => $user->id
            ]);
        }

        return back()->with('success', 'Akun berhasil ditambahkan. Kode verifikasi telah dikirim ke email.');
    }

    // Endpoint untuk memverifikasi kode
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Email tidak ditemukan'], 404);
        }

        if ($user->akses) {
            return response()->json(['status' => 'error', 'message' => 'Akun sudah aktif'], 400);
        }

        if ($user->verification_code != $request->code) {
            return response()->json(['status' => 'error', 'message' => 'Kode verifikasi salah'], 400);
        }

        // Aktifkan akun
        $user->akses = true;
        $user->verification_code = null; // hapus kode setelah diverifikasi
        $user->save();

        return response()->json(['status' => 'success', 'message' => 'Akun berhasil diverifikasi dan aktif']);
    }

    // Toggle akses (untuk admin/owner)
    public function toggleAccess($id)
    {
        $user = User::findOrFail($id);
        $user->akses = !$user->akses;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Status akses berhasil diubah',
            'akses' => $user->akses
        ]);
    }

    // Hapus akun
    public function destroy($id)
    {
        User::destroy($id);

        if (request()->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Akun berhasil dihapus'
            ]);
        }

        return back()->with('success', 'Akun berhasil dihapus');
    }

    // Tambahan: Resend verification code
    public function resendCode($id)
    {
        $user = User::findOrFail($id);

        if ($user->akses) {
            return response()->json(['status' => 'error', 'message' => 'Akun sudah aktif'], 400);
        }

        // Generate kode baru
        $verification_code = mt_rand(100000, 999999);
        $user->verification_code = $verification_code;
        $user->save();

        // Kirim email kode verifikasi baru
        Mail::to($user->email)->send(new VerifyAccountMail($user));

        return response()->json([
            'status' => 'success',
            'message' => 'Kode verifikasi baru telah dikirim ke email',
            'code' => $verification_code // opsional, untuk testing
        ]);
    }
}