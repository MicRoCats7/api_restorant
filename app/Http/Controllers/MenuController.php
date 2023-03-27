<?php

namespace App\Http\Controllers;

use App\Models\menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function create(Request $request)
    {
        $validation = $request->validate([
            'menuName' => 'required',
            'menuPrice' => 'required|integer',
            'menuStock' => 'required|integer',
            'menuBanner' => 'required',
            'categoryID' => 'required',
        ]);



        if ($request->menuBanner != "") {
            $image = $this->saveImage($request->menuBanner, 'menuBanner');
            $menuUpload = menu::create([
                'menuBanner' => "$image",
                'menuName' => $validation['menuName'],
                'menuPrice' => $validation['menuPrice'],
                'menuStock' => $validation['menuStock'],
                'categoryID' => $validation['categoryID']
            ]);

            return response([
                'message' => 'Berhasil Upload.',
                'data' => $menuUpload,
            ], 200);
        } else {
            return response([
                'message' => 'Mohon pilih banner makanan'
            ], 403);
        }
    }

    public function update(Request $request, $id)
    {

        $validation = $request->validate([
            'menuName' => 'required',
            'menuPrice' => 'required|integer',
            'menuStock' => 'required|integer',
            'menuBanner' => 'required',
        ]);
        $menuData = menu::find($id);

        if (!$menuData) {
            return response([
                'message' => 'Menu tidak ditemukan'
            ], 403);
        }

        if ($request->menuBanner != "") {
            $image = $this->saveImage($request->menuBanner, 'menuBanner');
            $menuUpload = $menuData->update([
                'menuBanner' => "$image",
                'menuName' => $validation['menuName'],
                'menuPrice' => $validation['menuPrice'],
                'menuStock' => $validation['menuStock']
            ]);

            return response([
                'message' => 'Berhasil Mengupdate Menu.',
                'data' => menu::find($id)->get(),
            ], 200);
        } else {
            return response([
                'message' => 'Mohon pilih banner makanan'
            ], 403);
        }
    }

    public function destroy($id)
    {
        $menuData = menu::find($id);

        if (!$menuData) {
            return response([
                'message' => 'Menu tidak ditemukan'
            ], 403);
        }

        $menuData->delete();


        return response([
            'message' => 'Berhasil Menghapus Menu.',
        ], 200);
    }

    public function readAll()
    {
        $allMenuData = menu::orderBy('created_at', 'desc')->with('categorys')->get();

        return response([
            'menu' => $allMenuData
        ], 200);
    }
}
