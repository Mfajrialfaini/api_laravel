<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // GET: api/users
    public function index()
    {
        $data = User::orderBy('id', 'asc')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diambil',
            'data' => $data
        ], 200);
    }

    // POST: api/users
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'NRP' => 'required|string|unique:users,NRP',
            'password' => 'required|min:6',
            'role' => 'nullable|string',
            'tingkat_kesatuan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('foto_user', 'public');
        }

        $user = User::create([
            'nama' => $request->nama,
            'NRP' => $request->NRP,
            'password' => $request->password,
            'role' => $request->role,
            'tingkat_kesatuan' => $request->tingkat_kesatuan,
            'foto' => $fotoPath,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User berhasil dibuat',
            'data' => $user
        ], 201);
    }


    // GET: api/users/{id}
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'User ditemukan',
            'data' => $user
        ], 200);
    }

    // PUT: api/users/{id}
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'nama' => 'required|string',
            'NRP' => 'required|string|unique:users,NRP,' . $id,
            'password' => 'nullable|min:6',
            'role' => 'nullable|string',
            'tingkat_kesatuan' => 'nullable|string',
            'foto' => 'nullable|string',
        ]);

        $user->nama = $request->nama;
        $user->NRP = $request->NRP;
        $user->role = $request->role;
        $user->tingkat_kesatuan = $request->tingkat_kesatuan;
        $user->foto = $request->foto;

        if ($request->password) {
            $user->password = $request->password; // auto hash
        }

        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'User berhasil diupdate',
            'data' => $user
        ], 200);
    }

    // DELETE: api/users/{id}
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User berhasil dihapus'
        ], 200);
    }
}
