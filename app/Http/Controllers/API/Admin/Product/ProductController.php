<?php

namespace App\Http\Controllers\API\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Image;

class ProductController extends Controller
{

    public function index()
    {
      $products =  Product::get();

      return response()->json([
        'products' => $products
      ], 200);
    }

    public function store(Request $request)
    {

        $request->validate([
            'category_id' => 'required',
            'brand_id' => 'required',
            'productcls_id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'mainDescription' => 'required',
            'imageOne' => 'required',
            'imageTwo' => 'required',
            'imageThree' => 'required',
        ]);

        $fileOne = explode(';', $request->imageOne);
        $fileOne = explode('/', $fileOne[0]);
        $file_one_ex = end($fileOne);

        $file_one_name = \Str::random(10) . '.' . $file_one_ex;

        $fileTwo = explode(';', $request->imageTwo);
        $fileTwo = explode('/', $fileTwo[0]);
        $file_two_ex = end($fileTwo);

        $file_two_name = \Str::random(10) . '.' . $file_two_ex;

        $fileThree = explode(';', $request->imageThree);
        $fileThree = explode('/', $fileThree[0]);
        $file_three_ex = end($fileThree);

        $file_three_name = \Str::random(10) . '.' . $file_three_ex;

        $prefix = 'LLP';

        $slug = slugify($request->name);

        $sku = $prefix . \Str::random(8);

        Product::create([
            'category_id' => $request->category_id,
            // 'brand_id' => $request->brand_id,
            // 'productcls_id' => $request->productcls_id,
            'name' => $request->name,
            'slug' => $slug,
            'sku' => $sku,
            'price' => $request->price,
            'description' => $request->description,
            'mainDescription' => $request->mainDescription,
            'imageOne' => $file_one_name,
            'imageTwo' => $file_two_name,
            'imageThree' => $file_three_name
        ]);

        Image::make($request->imageOne)->save(public_path('/uploads/images/product/').$file_one_name);
        Image::make($request->imageTwo)->save(public_path('/uploads/images/product/').$file_two_name);
        Image::make($request->imageThree)->save(public_path('/uploads/images/product/').$file_three_name);

        return response()->json('success', 201);

    }

    public function show($id)
    {

        $product = Product::where('id', $id)->first();

        return response()->json([
          'product' => $product
        ], 200);
    }

    public function update(Request $request, $id)
    {

        $product = Product::find($request->id);

        $imageOne = $product->imageOne;
        $imageTwo = $product->imageTwo;
        $imageThree = $product->imageThree;

        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->productcls_id = $request->productcls_id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->mainDescription = $request->mainDescription;
        $product->mainDescription = $request->mainDescription;

        $imageOnePath = public_path('/uploads/images/product/').$imageOne;
        if (file_exists($imageOnePath)) {
            unlink($imageOnePath);
        }

        if ($request->imageOne != $product->imageOne) {
            $fileOne = explode(';', $request->imageOne);
            $fileOne = explode('/', $fileOne[0]);
            $file_one_ex = end($fileOne);
            $file_one_name = \Str::random(10) . '.' . $file_one_ex;
            $product->imageOne = $file_one_name;
            Image::make($request->imageOne)->save(public_path('/uploads/images/product/').$file_one_name);
        }

        $imageTwoPath = public_path('/uploads/images/product/').$imageTwo;
        if (file_exists($imageTwoPath)) {
            unlink($imageTwoPath);
        }

        if ($request->imageTwo != $product->imageTwo) {
            $fileTwo = explode(';', $request->imageTwo);
            $fileTwo = explode('/', $fileTwo[0]);
            $file_two_ex = end($fileTwo);
            $file_two_name = \Str::random(10) . '.' . $file_two_ex;
            $product->imageTwo = $file_two_name;
            Image::make($request->imageTwo)->save(public_path('/uploads/images/product/').$file_two_name);
        }

        $imageThreePath = public_path('/uploads/images/product/').$imageThree;
        if (file_exists($imageThreePath)) {
            unlink($imageThreePath);
        }

        if ($request->imageThree != $product->imageThree) {
            $fileThree = explode(';', $request->imageThree);
            $fileThree = explode('/', $fileThree[0]);
            $file_three_ex = end($fileThree);
            $file_three_name = \Str::random(10) . '.' . $file_three_ex;
            $product->imageThree = $file_two_name;
            Image::make($request->imageThree)->save(public_path('/uploads/images/product/').$file_three_name);
        }

        $product->save();

        return response()->json('success', 200);
    }

    public function destroy($id)
    {

        $product = Product::find($id);

        $imageOne = $product->imageOne;
        $imageTwo = $product->imageTwo;
        $imageThree = $product->imageThree;

        $imageOnePath = public_path('/uploads/images/product/').$imageOne;
        if (file_exists($imageOnePath)) {
            unlink($imageOnePath);
        }

        $imageTwoPath = public_path('/uploads/images/product/').$imageTwo;
        if (file_exists($imageTwoPath)) {
            unlink($imageTwoPath);
        }

        $imageThreePath = public_path('/uploads/images/product/').$imageThree;
        if (file_exists($imageThreePath)) {
            unlink($imageThreePath);
        }

        $product->delete();

        return response()->json('success', 200);
    }
}
