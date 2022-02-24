<?php

namespace App\Http\Controllers;

use App\Models\address;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\NodeVisitor\FirstFindingVisitor;

class ProfileController extends Controller
{
    public function profile ($id)
    {
        $user = User::findOrFail($id);
        $addresses = address::where('user_id', $user->id)->get();
        return view('profile', compact('user', 'addresses')); 
    }   

    public function repeatOrder ($id, $order_id) {
        $order = Order::find($order_id);
        $products = $order->products;
        $cart = session('cart') ?? [];
        foreach ($products as $product) {
            $productId = $product->id;
            $quantity = $product->pivot->quantity;

            if (isset($cart[$productId])) {
                $cart[$productId] = $cart[$productId] + $quantity;
            } else {
                $cart[$productId] = $quantity;
            }

        session()->put('cart', $cart);        
        }
        return redirect()->route('cart');
    }

    public function orderHistory ($id) {
        $data = [
            'title' =>  'История заказов',
            'productSum' => 0,
            'summ' => 0,
        ];
        
        $user = User::findOrFail($id);
        $orders = Order::where('user_id', $id)->get() ?? null;
        return view('orderHistory', compact('user', 'orders'), $data);        
    }

    public function save(Request $request)
    {
        $input = request()->all();

        request()->validate([
            'name' => 'required',
            'email' => "email|required|unique:users,email,{$input['userId']}",
            'picture' => 'mimetypes:image/*',
            'current_password' => 'current_password|nullable',
            'password' => 'confirmed|min:8|nullable', // правило само ищет поле password_confirmation для поля password (может быть любое имя (но и в поле подтверждения дб оно же))
        ]);        

        $name = $input['name'];
        $email = $input['email'];
        $userId = $input['userId'];
        $picture = $input['picture'] ?? null;
        $newAddress = $input['new_address'];
        $user = User::find($userId);
        $setAsDefault = $input['setAsDefault'] ?? null;
        $newAddrToMain = $input['newAddrToMain'] ?? null;
        $addressesToDelete = $input['addressesToDelete'] ?? null;

        if ($input['password']){
            $user->password = Hash::make($input['password']);
            $user->save();
        }

        if ($newAddress && $newAddrToMain) {
            address::where('user_id', $user->id)->update([
                'main' => 0
            ]);
            address::create([
                'user_id' => $user->id,
                'address' => $newAddress,
                'main' => 1
            ]);
        } else if ($newAddress && !$newAddrToMain) {
            address::create([
                'user_id' => $user->id,
                'address' => $newAddress,
                'main' => 0
            ]);
            address::where('user_id', $user->id)->update([
                'main' => 0
            ]);
            address::where('id', $setAsDefault)->update([
            'main' => 1
            ]);
        } else {
            address::where('user_id', $user->id)->update([
                'main' => 0
            ]);
            address::where('id', $setAsDefault)->update([
            'main' => 1
            ]);
            }

        if ($picture) {
            $ext = $picture->getClientOriginalExtension();
            $fileName = time() . rand(10000, 99999) . '.' . $ext;
            $picture->storeAs('public/users', $fileName);
            $user->picture = "users/$fileName";
        };

        if ($addressesToDelete) { 
            foreach ($addressesToDelete as $addressToDelete) {
                //if (Order::where('address_id', $addressToDelete)->first()) {
                if (address::find($addressToDelete)->orders->count()) {
                    session()->flash('addrCanNotBeDelete');
                } else { 
                    address::find($addressToDelete) -> delete();
                }
            }
        };

        $user->name = $name;
        $user->email = $email;  
        $user->save();
        return back();
    }
}