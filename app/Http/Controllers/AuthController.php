<?php

namespace App\Http\Controllers;
use App\Models\Wallets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AuthController extends Controller
{

    public function register(Request $request)
            {
            $validatedData = $request->validate([
            'name' => 'required|string|max:255',
                            'email' => 'required|string|max:255|unique:users',
                            'password' => 'required|string|min:8',
            ]);

                $user = User::create([
                        'name' => $validatedData['name'],
                            'email' => $validatedData['email'],
                            'password' => Hash::make($validatedData['password']),
                            'role_id' => 3
                ]);

            $token = $user->createToken('auth_token')->plainTextToken;
            $wallets = new Wallets();
            $wallets->balance = 0;
            $wallets->user_id = $user->id;
            $wallets->save();
            return response()->json([
                        'access_token' => $token,
                            'token_type' => 'Bearer',
            ]);
            }


            public function login(Request $request)
                {
                if (!\Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                'message' => 'Invalid login details'
                        ], 401);
                    }

                $user = User::where('email', $request['email'])->firstOrFail();

                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                        'access_token' => $token,
                        'token_type' => 'Bearer',
                ]);
                }


                public function me(Request $request)
                {
                   return $request->user();
                }



                public function deleteaccount()
                {
                    $authUser = User::find(\Auth::id());
                    $user = User::where('id', $authUser->id)->firstOrFail();
                    $user->email = $user->email.":DELETED";
                    $user->save();
                    return $user;
                }

                public function updatetokne(Request $request){
                    $authUser = User::find(\Auth::id());
                    $user = User::where('id', $authUser->id)->firstOrFail();
                    $user->fbtoken = $request->fbtoken;
                    $user->save();
                    return $user;
                }

}
