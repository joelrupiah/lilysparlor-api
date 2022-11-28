<?php

namespace App\Http\Controllers\API\Admin\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Auth;

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
