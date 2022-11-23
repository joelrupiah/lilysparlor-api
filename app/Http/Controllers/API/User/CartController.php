<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use App\Models\Service;
use Auth;

class CartController extends Controller
{

    public function index()
    {
        $user = Auth::user()->id;
        $carts = Cart::where('user_id', $user)
            ->orderBy('created_at', 'DESC')
            ->with('product')
            ->get();

        return response()->json([
            'carts' => $carts
        ], 200);
    }

    public function store(Request $request)
    {
        $user = Auth::user()->id;

        $product = $request->product['id'];
        $amount = $request->product['price'];
        $item = Cart::where('product_id', $product);

        if($item->count())
        {
            $item->increament('quantity');
            $item = $item->first();
        }
        else
        {
            $item = Cart::forceCreate([
                'user_id' => $user,
                'product_id' => $product,
                'service_id' => $product,
                'quantity' => 1,
                'amount' => $amount
            ]);
        }

        return response()->json([
            'user' => $item->user,
            'quantity' => $item->quantity,
            'product' => $item->product,
            'amount' => $item->amount
        ], 200);
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
        $item = Cart::where('product_id', $id)->delete();
        return response('success', 200);
    }

    public function destroyAll()
    {
        Cart::truncate();
    }
}
