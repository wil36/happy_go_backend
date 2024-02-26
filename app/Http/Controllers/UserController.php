<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        try {
            $membre = Auth::user();
            return view('profile.update_profile', ['user' => $membre]);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request, User $user)
    {
        try {
            $attributeNames = array(
                'email' => 'email',
                'name' => 'nom',
            );
            $validator = FacadesValidator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->where(function ($query) use ($request) {
                    $query->where('id', '!=', $request['id']);
                })],
            ]);
            $validator->setAttributeNames($attributeNames);
            if ($validator->fails()) {
                return response()
                    ->json(['errors' => $validator->errors()->all()]);
            }
            DB::beginTransaction();
            $user = User::find($request['id']);
            $user['name'] = $request['name'];
            $user['email'] = $request['email'];
            $user->save();

            DB::commit();
            return response()->json(["success" => "Modification éffectuer !"]);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()]);
            return response()->json(["error" => "Une erreur s'est produite."]);
        }
    }

    public function changePassword()
    {
        try {
            return view('profile.update_password');
        } catch (Exception $e) {
            return response()->json(["error" => "Une erreur s'est produite."]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        try {
            $attributeNames = array(
                'password' => 'Nouveau Mot de passe',
                'current_password' => 'Mot de passe actuel',
            );
            $validator = FacadesValidator::make($request->all(), [
                'current_password' => ['required', 'string'],
                'password' => ['required', 'string', 'min:4'],
            ]);
            $validator->setAttributeNames($attributeNames);
            if ($validator->fails()) {
                return response()
                    ->json(['errors' => $validator->errors()->all()]);
            }
            $user = User::findOrFail(Auth::user()->id);
            if (!isset($request['current_password']) || !Hash::check($request['current_password'], $user->password)) {
                return response()->json(["error" => "Le mot de passe actuel est incorect"]);
            }
            $user->password = Hash::make($request['password']);
            $user->save();
            return response()->json(["success" => "Modification éffectuer !"]);
        } catch (Exception $e) {
            return response()->json(
                ["error" => $e->getMessage()]
            );
            return response()->json(["error" => "Une erreur s'est produite."]);
        }
    }
}
