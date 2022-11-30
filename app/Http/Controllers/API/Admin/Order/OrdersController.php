<?php

namespace App\Http\Controllers\API\Admin\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Auth;
use Image;

class OrdersController extends Controller
{

    public function index()
    {
        $orders = Order::orderBy('updated_at', 'DESC')
                    ->with('user')
                    ->get();

        return response()->json([
            'orders' => $orders
        ], 200);
    }

    public function getUserSpecificOrder($order_id)
    {
        $order = Order::where('order_id', $order_id)
                ->with('user')
                ->first();

        return response()->json([
            'order' => $order
        ], 200);
    }

    public function updateBooking(Request $request, Order $order)
    {
      // return $request->order_id;

      $request->validate([
        'admin_id' => 'required',
        'image_one' => 'required',
        'image_two' => 'required',
        'image_three' => 'required',
      ]);

      $order = Order::where('order_id', $request->order_id)->first();
      // return $order;

      $order->admin_id = $request->admin_id;
      $order->status = implode(",",  $request['status']);

      if ($request->image_one != $order->image_one) {
          $fileOne = explode(';', $request->image_one);
          $fileOne = explode('/', $fileOne[0]);
          $file_one_ex = end($fileOne);
          $file_one_name = \Str::random(10) . '.' . $file_one_ex;
          $order->image_one = $file_one_name;
          Image::make($request->image_one)->save(public_path('/uploads/images/order/').$file_one_name);
      }

      if ($request->image_two != $order->image_two) {
          $fileTwo = explode(';', $request->image_two);
          $fileTwo = explode('/', $fileTwo[0]);
          $file_two_ex = end($fileTwo);
          $file_two_name = \Str::random(10) . '.' . $file_two_ex;
          $order->image_two = $file_two_name;
          Image::make($request->image_two)->save(public_path('/uploads/images/order/').$file_two_name);
      }

      if ($request->image_three != $order->image_three) {
          $fileThree = explode(';', $request->image_three);
          $fileThree = explode('/', $fileThree[0]);
          $file_three_ex = end($fileThree);
          $file_three_name = \Str::random(10) . '.' . $file_three_ex;
          $order->image_three = $file_three_name;
          Image::make($request->image_three)->save(public_path('/uploads/images/order/').$file_three_name);
      }

      $order->update();

      return response()->json('success', 200);
    }

    public function store(Request $request)
    {
        //
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
