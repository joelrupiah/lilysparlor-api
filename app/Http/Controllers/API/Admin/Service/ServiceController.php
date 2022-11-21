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

      $slug = slugify($request->name);

      Service::create([
          'name' => $request->name,
          'slug' => $slug,
          'price' => $request->price,
          'description' => $request->description,
          'mainDescription' => $request->mainDescription,
          'imageOne' => $file_one_name,
          'imageTwo' => $file_two_name,
          'imageThree' => $file_three_name
      ]);

      Image::make($request->imageOne)->save(public_path('/uploads/images/service/').$file_one_name);
      Image::make($request->imageTwo)->save(public_path('/uploads/images/service/').$file_two_name);
      Image::make($request->imageThree)->save(public_path('/uploads/images/service/').$file_three_name);

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

      $service = Service::find($request->id);

      $imageOne = $service->imageOne;
      $imageTwo = $service->imageTwo;
      $imageThree = $service->imageThree;

      $service->name = $request->name;
      $service->price = $request->price;
      $service->description = $request->description;
      $service->mainDescription = $request->mainDescription;

      $imageOnePath = public_path('/uploads/images/service/').$imageOne;
      if (file_exists($imageOnePath)) {
          unlink($imageOnePath);
      }

      if ($request->imageOne != $service->imageOne) {
          $fileOne = explode(';', $request->imageOne);
          $fileOne = explode('/', $fileOne[0]);
          $file_one_ex = end($fileOne);
          $file_one_name = \Str::random(10) . '.' . $file_one_ex;
          $service->imageOne = $file_one_name;
          Image::make($request->imageOne)->save(public_path('/uploads/images/service/').$file_one_name);
      }

      $imageTwoPath = public_path('/uploads/images/service/').$imageTwo;
      if (file_exists($imageTwoPath)) {
          unlink($imageTwoPath);
      }

      if ($request->imageTwo != $service->imageTwo) {
          $fileTwo = explode(';', $request->imageTwo);
          $fileTwo = explode('/', $fileTwo[0]);
          $file_two_ex = end($fileTwo);
          $file_two_name = \Str::random(10) . '.' . $file_two_ex;
          $service->imageTwo = $file_two_name;
          Image::make($request->imageTwo)->save(public_path('/uploads/images/service/').$file_two_name);
      }

      $imageThreePath = public_path('/uploads/images/service/').$imageThree;
      if (file_exists($imageThreePath)) {
          unlink($imageThreePath);
      }

      if ($request->imageThree != $service->imageThree) {
          $fileThree = explode(';', $request->imageThree);
          $fileThree = explode('/', $fileThree[0]);
          $file_three_ex = end($fileThree);
          $file_three_name = \Str::random(10) . '.' . $file_three_ex;
          $service->imageThree = $file_two_name;
          Image::make($request->imageThree)->save(public_path('/uploads/images/service/').$file_three_name);
      }

      $service->save();

      return response()->json('success', 200);
  }

  public function destroy($id)
  {

      $service = Service::find($id);

      $imageOne = $service->imageOne;
      $imageTwo = $service->imageTwo;
      $imageThree = $service->imageThree;

      $imageOnePath = public_path('/uploads/images/service/').$imageOne;
      if (file_exists($imageOnePath)) {
          unlink($imageOnePath);
      }

      $imageTwoPath = public_path('/uploads/images/service/').$imageTwo;
      if (file_exists($imageTwoPath)) {
          unlink($imageTwoPath);
      }

      $imageThreePath = public_path('/uploads/images/service/').$imageThree;
      if (file_exists($imageThreePath)) {
          unlink($imageThreePath);
      }

      $service->delete();

      return response()->json('success', 200);
  }

}
