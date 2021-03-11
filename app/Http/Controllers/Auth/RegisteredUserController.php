<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class RegisteredUserController extends Controller
{
    /**
     * @OA\Post(
     *      path="/register",
     *      operationId="registerUser",
     *      tags={"Auth"},
     *      summary="Register a new user",
     *      description="Returns new user data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"email","password", "tempo"},
     *              @OA\Property(property="email", type="email", example="xuser@stuba.sk"),
     *              @OA\Property(property="password", type="password", example="password"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Invalid request body.",
     *          @OA\JsonContent(
     *              @OA\Property(property="user_id", type="integer", example="1")
     *        )
     *     ),
     *     @OA\Response(
     *          response=422,
     *          description="Invalid request body.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Sorry, invalid request body.")
     *        )
     *     )
     * )
     */
    public function store(StoreUserRequest $request)
    {
//        $request->validate([
//            'name' => 'required|string|max:255',
//            'email' => 'required|string|email|max:255|unique:users',
//            'password' => 'required|string|confirmed|min:8',
//        ]);
//
//        Auth::login($user = User::create([
//            'name' => $request->name,
//            'email' => $request->email,
//            'password' => Hash::make($request->password),
//        ]));
//
//        event(new Registered($user));
//
//        return redirect(RouteServiceProvider::HOME);
    }
}
