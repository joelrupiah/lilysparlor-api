<?php

namespace App\Http\Controllers\API\Admin\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Image;

class ServiceController extends Controller
{

  public function index()
  {
    $services =  Service::get();

    return response()->json([
      'services' => $services
    ], 200);
  }

  public function userIndex()
  {
      $services =  Service::get();

    return response()->json([
      'services' => $services
    ], 200);
  }

  public function store(Request $request)
  {

      // return $request;

      $request->validate([
          'name' => 'required',
          'price' => 'required',
          'description' => 'required',
          'mainDescription' => 'required',
          'image_one' => 'required',
          'image_two' => 'required',
          'image_three' => 'required',
      ]);

      $fileOne = explode(';', $request->image_one);
      $fileOne = explode('/', $fileOne[0]);
      $file_one_ex = end($fileOne);

      $file_one_name = \Str::random(10) . '.' . $file_one_ex;

      $fileTwo = explode(';', $request->image_two);
      $fileTwo = explode('/', $fileTwo[0]);
      $file_two_ex = end($fileTwo);

      $file_two_name = \Str::random(10) . '.' . $file_two_ex;

      $fileThree = explode(';', $request->image_three);
      $fileThree = explode('/', $fileThree[0]);
      $file_three_ex = end($fileThree);

      $file_three_name = \Str::random(10) . '.' . $file_three_ex;

      $slug = slugify($request->name);

      Service::create([
          'name' => $request->name,
          'slug' => $slug,
          'price' => $request->price,
          'description' => $request->description,
          'mainDescription' => $request->mainDescription,
          'image_one' => $file_one_name,
          'image_two' => $file_two_name,
          'image_three' => $file_three_name
      ]);

      Image::make($request->image_one)->save(public_path('/uploads/images/service/').$file_one_name);
      Image::make($request->image_two)->save(public_path('/uploads/images/service/').$file_two_name);
      Image::make($request->image_three)->save(public_path('/uploads/images/service/').$file_three_name);

      return response()->json('success', 201);

  }

  public function show($id)
  {

      $service = Service::where('id', $id)->first();

      return response()->json([
        'service' => $service
      ], 200);
  }

  public function update(Request $request, $id)
  {

      // $request->validate([
      //     'name' => 'required',
      //     'price' => 'required',
      //     'description' => 'required',
      //     'mainDescription' => 'required',
      //     'image_one' => 'required',
      //     'image_two' => 'required',
      //     'image_three' => 'required',
      // ]);

      $service = Service::find($request->id);

      $image_one = $service->image_one;
      $image_two = $service->image_two;
      $image_three = $service->image_three;

      $service->name = $request->name;
      $service->price = $request->price;
      $service->description = $request->description;
      $service->mainDescription = $request->mainDescription;

      $imageOnePath = public_path('/uploads/images/service/').$image_one;
      if (file_exists($imageOnePath)) {
          unlink($imageOnePath);
      }

      if ($request->image_one != $service->image_one) {
          $fileOne = explode(';', $request->image_one);
          $fileOne = explode('/', $fileOne[0]);
          $file_one_ex = end($fileOne);
          $file_one_name = \Str::random(10) . '.' . $file_one_ex;
          $service->image_one = $file_one_name;
          Image::make($request->image_one)->save(public_path('/uploads/images/service/').$file_one_name);
      }

      $imageTwoPath = public_path('/uploads/images/service/').$image_two;
      if (file_exists($imageTwoPath)) {
          unlink($imageTwoPath);
      }

      if ($request->image_two != $service->image_two) {
          $fileTwo = explode(';', $request->image_two);
          $fileTwo = explode('/', $fileTwo[0]);
          $file_two_ex = end($fileTwo);
          $file_two_name = \Str::random(10) . '.' . $file_two_ex;
          $service->image_two = $file_two_name;
          Image::make($request->image_two)->save(public_path('/uploads/images/service/').$file_two_name);
      }

      $imageThreePath = public_path('/uploads/images/service/').$image_three;
      if (file_exists($imageThreePath)) {
          unlink($imageThreePath);
      }

      if ($request->image_three != $service->image_three) {
          $fileThree = explode(';', $request->image_three);
          $fileThree = explode('/', $fileThree[0]);
          $file_three_ex = end($fileThree);
          $file_three_name = \Str::random(10) . '.' . $file_three_ex;
          $service->image_three = $file_two_name;
          Image::make($request->image_three)->save(public_path('/uploads/images/service/').$file_three_name);
      }

      $service->save();

      return response()->json('success', 200);
  }

  public function destroy($id)
  {

      $service = Service::find($id);

      $image_one = $service->image_one;
      $image_two = $service->image_two;
      $image_three = $service->image_three;

      $imageOnePath = public_path('/uploads/images/service/').$image_one;
      if (file_exists($imageOnePath)) {
          unlink($imageOnePath);
      }

      $imageTwoPath = public_path('/uploads/images/service/').$image_two;
      if (file_exists($imageTwoPath)) {
          unlink($imageTwoPath);
      }

      $imageThreePath = public_path('/uploads/images/service/').$image_three;
      if (file_exists($imageThreePath)) {
          unlink($imageThreePath);
      }

      $service->delete();

      return response()->json('success', 200);
  }

}
