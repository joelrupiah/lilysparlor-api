<?php

namespace App\Http\Controllers\API\Admin\Brand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Image;

class BrandController extends Controller
{

    public function index()
    {
        $brands =  Brand::get();

        return response()->json([
          'brands' => $brands
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
          'name' => 'required',
        ]);


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
