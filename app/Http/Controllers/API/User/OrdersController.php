<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use Auth;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Storage;

class OrdersController extends Controller
{

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        // return $request;
        $user = Auth::user()->id;
        $product = $request->cart;
        $shipping = $request->form;
        // return $product;
        // return $shipping;
        $order_id = rand(99999, 999999);
        $total = $request->total;
        if ($request->payment['cash_on_delivery']) {

            $products = Cart::where('user_id', $user)->get();

            // $productSave = serialize($product);

            Order::create([
                'product' => $product,
                'shipping' => $shipping,
                'user_id' => $user,
                'order_id' => $order_id,
                'total' => $total,
                'payment' => 'cash_on_delivery',
                'status' => 'pending'
            ]);

            $this->downloadPdf($order_id);

            // Cart::where('user_id', $user)->delete();

            return response()->json('success', 200);

        }
        else {
            return response()->json('Failed', 404);
        }
    }

    public function downloadPdf($order_id)
    {
        // return $order_id;
        $order = Order::where('order_id', $order_id)
                ->with('user')
                ->first();
        
        $data = [
            'order_name' => $order_id
        ];

        // return $order->user->name;

        $pdf = PDF::loadView('order.invoice', $data);

        Order::sendCustomerEmail($order, $pdf);

        return response()->json('success', 200);

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
