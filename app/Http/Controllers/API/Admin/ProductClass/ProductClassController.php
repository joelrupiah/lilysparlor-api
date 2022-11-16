<?php

namespace App\Http\Controllers\API\Admin\ProductClass;

use App\Http\Controllers\Controller;
use App\Models\Productcls;
use Illuminate\Http\Request;

class ProductClassController extends Controller
{
    public function index()
    {
      $productclasses =  Productcls::get();

      return response()->json([
        'productclasses' => $productclasses
      ], 200);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required'
        ]);

        $slug = slugify($request->name);

        Productcls::create([
            'name' => $request->name,
            'slug' => $slug
        ]);

        return response()->json('success', 201);

    }

    public function show($id)
    {

        $productclass = Productcls::where('id', $id)->first();

        return response()->json([
          'productclass' => $productclass
        ], 200);
    }

    public function update(Request $request, $id)
    {

        $productclass = Productcls::find($request->id);

        $productclass->name = $request->name;

        $productclass->save();

        return response()->json('success', 200);
    }

    public function destroy($id)
    {

        $productclass = Productcls::find($id);

        $productclass->delete();

        return response()->json('success', 200);
    }
}
