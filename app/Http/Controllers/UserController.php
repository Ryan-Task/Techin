<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
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

public function store(Request $request)
{
$request->validate([
'name' => 'required',
'email' => 'required|email|unique:users',
'password' => 'required|min:6',
'role' => 'required|in:teknisi,owner',
]);

User::create([
'name' => $request->name,
'email' => $request->email,
'password' => Hash::make($request->password),
'role' => $request->role,
'akses' => true,
]);

return back()->with('success', 'Akun berhasil ditambahkan');
}

public function toggleAccess($id)
{
$user = User::findOrFail($id);
$user->akses = !$user->akses;
$user->save();

return response()->json(['status' => 'success', 'akses' => $user->akses]);
}

public function destroy($id)
{
User::destroy($id);
return back()->with('success', 'Akun berhasil dihapus');
}
}