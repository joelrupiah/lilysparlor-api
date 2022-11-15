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
        // return $id;
        $category = Category::where('id', $id)->first();

        return response()->json([
          'category' => $category
        ], 200);
    }

    public function update(Request $request, $id)
    {
        return $request;
        $category = Category::find($request->id);

        // return $category

        $image = $category->image;
        $category->name = $request->name;

        $imagePath = public_path('/uploads/images/category/').$image;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        if ($request->image != $category->image) {
            $file = explode(';', $request->image);
            $file = explode('/', $file[0]);
            $file_ex = end($file);
            $file_name = \Str::random(10) . '.' . $file_ex;
            $category->image = $file_name;
            Image::make($request->image)->save(public_path('/uploads/images/category/').$file_name);
        }

        $category->save();

        return response()->json('success', 200);
    }

    public function destroy($id)
    {
        // return $id;
        $category = Category::find($id);
        // return $category->image;
        $image = $category->image;
        $imagePath = public_path('/uploads/images/category/').$image;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $category->delete();

        return response()->json('success', 200);
    }
}
