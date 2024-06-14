<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function loginOrCreate(Request $request)
    {
        $phone = $request->input('phone');
        $user = User::where('phone', $phone)->first();
        $token = "";
        if ($user) {
            $user->update(['phone_verified_at' => now()]);
            $token = $user->createToken('Q76vU59/M4LKpydDRVGQzP+TG2xR9J3Spx8qziB25FY=')->plainTextToken;
        } else {
            $user = User::create([
                'name' => $request->input('name'),
                'phone' => $phone,
                'phone_verified_at' => now(),
                'password' => Hash::make('password'),
            ]);

            $token = $user->createToken('Q76vU59/M4LKpydDRVGQzP+TG2xR9J3Spx8qziB25FY=')->plainTextToken;
        }

        return response()->json(['token' => $token], 200);
    }
}