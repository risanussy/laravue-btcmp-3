<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();

        return response()->json([
            'message' => 'Product Berhasil Diambil',
            'code' => 200,
            'data' => $products
        ]);
    }

    public function show($id){
        $products = Product::find($id);

        return response()->json([
            'message' => 'Product Berhasil Diambil',
            'code' => 200,
            'data' => $products
        ]);
    }

    public function store(Request $request){
        $data = $request->validate([
            'nama' => 'required',
            'desc' => 'required',
            'foto' => 'required|image',
            'harga' => 'required|numeric',
        ]);

        if($request->hasFile('foto')){
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images') , $imageName);

            $data['foto'] = $imageName;
        }

        $products = Product::create($data);

        return response()->json([
            'message' => 'Product Berhasil Diambil',
            'code' => 200,
            'data' => $products
        ]);
    }

    public function edit(Request $request, $id){
        $data = $request->validate([
            'nama' => 'required',
            'desc' => 'required',
            'foto' => 'required|image',
            'harga' => 'required|numeric',
        ]);

        $products = Product::find($id);

        if($request->hasFile('foto')){
            // cek dan hapus
            if(!empty($products->foto)){
                $imagePath = public_path('images/', $products->foto);

                if(file_exists($imagePath)){
                    unlink($imagePath);
                }
            }

            $image = $request->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images') , $imageName);

            $data['foto'] = $imageName;
        }

        $products->update($data);

        return response()->json([
            'message' => 'Product Berhasil Diambil',
            'code' => 200,
            'data' => $products
        ]);
    }

    public function delete($id){
        $products = Product::find($id);
        
        if(!empty($products->foto)){
            $imagePath = public_path('images/'. $products->foto);

            if(file_exists($imagePath)){
                unlink($imagePath);
            }
        }

        $products->delete();

        return response()->json([
            'message' => 'Product Berhasil Dihapus',
            'code' => 200,
            'data' => $products
        ]);
    }
}
