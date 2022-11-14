<?php

namespace App\Http\Controllers\API\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Image;

class CategoryController extends Controller
{

    public function index()
    {
      $categories =  Category::get();

      return response()->json([
        'categories' => $categories
      ], 200);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'image' => 'required'
        ]);

        $file = explode(';', $request->image);
        $file = explode('/', $file[0]);
        $file_ex = end($file);

        $file_name = \Str::random(10) . '.' . $file_ex;

        $slug = slugify($request->name);

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'image' => $file_name
        ]);

        Image::make($request->image)->save(public_path('/uploads/images/category/').$file_name);

        return response()->json('success', 201);

    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
