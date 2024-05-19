<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Function Create
    public function create(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validasi->fails()) {
            return response()->json($validasi->messages())->setStatusCode(422);
        }

        $payload = $validasi->validated();
        Category::create([
            'name' => $payload['name'],
        ]);

        return response()->json([
            'message' => 'Data Category berhasil disimpan'
        ])->setStatusCode(201);
    }

    // Function Read
    function read(){
        $category = Category::all();
        return response()->json([
            'msg' => 'Data Produk Keseluruhan',
            'data' => $category
        ],200);

    }
    
    // Function Update
    public function update(Request $request, $id)
    {
        $validasi = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validasi->fails()) {
            return response()->json($validasi->messages())->setStatusCode(422);
        }
        $valid = $validasi->validated();
        $category = Category::findOrFail($id);
        if ($category) {
            Category::where('id', $id)->update($valid);
            return response()->json([
                'message' => 'Data Category berhasil diupdate'
            ])->setStatusCode(200);
        }
        return response()->json(['data dengan id (' . $id . ')tidak di  temukan']);
    }

    // Function Delete
    public function delete($id){
        $category = Category::find ($id);

        if ($category) {
            Category::where('id', $id)->delete();

            return response()->json([
                'msg' => 'Data produk dengan ID: '.$id.' berhasil dihapus' 
            ], 200);
        }

        return response()->json([
            'msg' => 'Data produk dengan ID: '.$id.' tidak ditemukan', 
        ],400);
    }
}