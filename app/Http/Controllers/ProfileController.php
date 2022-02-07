<?php

namespace App\Http\Controllers;

use App\Models\address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile ($id)
    {
        $user = User::findOrFail($id);
        $addresses = address::where('user_id', $user->id)->get();
        return view('profile', compact('user', 'addresses')); 
    }

    public function save(Request $request)
    {
        $input = request()->all();

        request()->validate([
            'name' => 'required',
            'email' => "email|required|unique:users,email,{$input['userId']}",
            'picture' => 'mimetypes:image/*',
            'current_password' => 'current_password|nullable',
            'password' => 'confirmed|min:8|nullable' // правило само ищет поле password_confirmation для поля password (может быть любое имя (но и в поле подтверждения дб оно же))
        ]);        

        $name = $input['name'];
        $email = $input['email'];
        $userId = $input['userId'];
        $picture = $input['picture'] ?? null;
        $newAddress = $input['new_address'];
        $user = User::find($userId);
        $setAsDefault = $input['setAsDefault'] ?? null;
        $addressesToDelete = $input['addressesToDelete'] ?? null;

        $user->password = Hash::make($input['password']);
        $user->save();

        if ($setAsDefault) {
            address::where('user_id', $user->id)->update([
                'main' => 0
            ]);
            address::where('id', $setAsDefault)->update([
                'main' => 1
            ]);
        } 

        if ($newAddress) {
            address::create([
                'user_id' => $user->id,
                'address' => $newAddress,
                'main' => 0
            ]);
        }

        if ($picture) {
            $ext = $picture->getClientOriginalExtension();
            $fileName = time() . rand(10000, 99999) . '.' . $ext;
            $picture->storeAs('public/users', $fileName);
            $user->picture = "users/$fileName";
        }

        if ($addressesToDelete) { 
            foreach ($addressesToDelete as $addressToDelete) {
                //address::where('id', $addressToDelete)->delete();
                address::find($addressToDelete)->delete();
            }
        }

        $user->name = $name;
        $user->email = $email;  
        $user->save();
        return back();
    }
}