<?php

namespace App\Http\Controllers;

use App\Models\categoryMenu;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create(Request $request)
    {
        $validation = $request->validate([
            'categoryName' => 'required',
            'categoryBanner' => 'required'
        ]);



        if ($request->categoryBanner != "") {
            $image = $this->saveImage($request->categoryBanner, 'categoryBanner');
            $menuUpload = categoryMenu::create([
                'categoryLogo' => "$image",
                'categoryName' => $validation['categoryName'],
            ]);

            return response([
                'message' => 'Berhasil Upload.',
                'data' => $menuUpload,
            ], 200);
        }
    }


    public function update(Request $request, $id)
    {
        $menuData = categoryMenu::find($id);

        if (!$menuData) {
            return response([
                'message' => 'Category tidak ditemukan'
            ], 403);
        }

        $validation = $request->validate([
            'categoryName' => 'required',
            'categoryBanner' => 'required'
        ]);

        if ($request->categoryBanner != "") {
            $image = $this->saveImage($request->categoryBanner, 'categoryBanner');
            $menuUpload = $menuData->update([
                'categoryLogo' => "$image",
                'categoryName' => $validation['categoryName'],
            ]);

            return response([
                'message' => 'Berhasil Mengupdate Category.',
                'data' => $menuUpload,
            ], 200);
        } else {
            return response([
                'message' => 'Mohon pilih banner Category'
            ], 403);
        }
    }

    public function destroy($id)
    {
        $menuData = categoryMenu::find($id);

        if (!$menuData) {
            return response([
                'message' => 'Category tidak ditemukan'
            ], 403);
        }

        $menuData->delete();


        return response([
            'message' => 'Berhasil Menghapus Category.',
        ], 200);
    }


    public function getCategory()
    {
        $category = categoryMenu::all();

        return response([
            'category' => $category
        ], 200);
    }
    public function readMenu()
    {
        $allMenuData = categoryMenu::orderBy('created_at', 'desc')->with('menus')->get();

        return response([
            'category' => $allMenuData
        ], 200);
    }
}
