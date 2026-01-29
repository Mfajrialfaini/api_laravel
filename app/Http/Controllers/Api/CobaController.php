<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\coba;
use Illuminate\Http\Request;

class CobaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = coba::orderBy('id', 'asc')->get();
        return response()->json([
            'status' => true,
            'message' => 'Data sudah berhasil',
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datacoba = new coba;
        $datacoba->nama = $request->nama;
        $datacoba->NRP = $request->NRP;
        $datacoba->password = bcrypt($request->password);
        $post = $datacoba->save();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan',
            'data' => $datacoba
        ], 201);
    }


    public function show(string $id)
    {
        $data = coba::find($id);
        if ($data) {
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => $data
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }
    }


    public function update(Request $request, string $id)
    {
        $datacoba = coba::find($id);
        if (!$datacoba) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $datacoba->nama = $request->nama;
        $datacoba->NRP = $request->NRP;
        $datacoba->password = bcrypt($request->password);
        $post = $datacoba->save();

        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil Di Update',
            'data' => $datacoba
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $datacoba = coba::find($id);
        if (!$datacoba) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $post = $datacoba->save();

        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil Di Hapus',
            'data' => $datacoba
        ], 201);
    }
}
