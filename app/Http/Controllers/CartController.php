<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function cart () {

        $title = 'Корзина' . ' (' . array_sum(session('cart') ?? []) . ')';
        $cart = session('cart') ?? [] ;
        $user = Auth::user();

        $products = Product::whereIn('id', array_keys($cart))
                        ->get()
                        ->transform(function ($product) use ($cart) {
                            $product->quantity = $cart[$product->id];
                            return $product;
                        });

        return view('cart', compact('products', 'title', 'user'));
    }

    public function addToCart () 
    {
        $productId = request('id');
        $cart = session('cart') ?? [];

        if (isset($cart[$productId])) {
            $cart[$productId] = ++$cart[$productId];
        } else {
            $cart[$productId] = 1;
        }

        session()->put('cart', $cart);
        return back();
    }

    public function removeFromCart () {
        $productId = request('id');
        $cart = session('cart') ?? [];

        if (!isset($cart[$productId]))
            return back();
        
        $quantity = $cart[$productId];
        if ($quantity > 1) {
            $cart[$productId] = --$quantity;
        } else {
            unset($cart[$productId]);
        }

        session()->put('cart', $cart);
        return back();
    }

    public function createOrder ()
    {
        $user = Auth::user();
        if ($user) {
            $address = $user->getMainAddress();
            $cart = session('cart');
            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $address->id
            ]);

            foreach ($cart as $id => $quantity) {
                $product = Product::find($id);
                $order->products()->attach($product, [
                    'quantity' => $quantity,
                    'price' => $product->price
                ]);
            }
        }
        session()->forget('cart');
        return back();
    }
}
