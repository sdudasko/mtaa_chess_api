<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/register/passport",
     *      operationId="registerUser",
     *      tags={"Auth"},
     *      summary="Register a new user",
     *      description="Returns new user data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"email","password"},
     *              @OA\Property(property="email", type="email", example="xuser@stuba.sk"),
     *              @OA\Property(property="name", type="email", example="xuser"),
     *              @OA\Property(property="password", type="password", example="password"),
     *              @OA\Property(property="password_confirmation", type="password", example="password"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Success",
     *           @OA\JsonContent(
     *              type="object",
     *              example={
     *                    "user": {
     *                          "name": "xuser",
     *                          "email": "xuser@stuba.sk",
     *                          "updated_at": "2021-03-25T11:47:13.000000Z",
     *                          "created_at": "2021-03-25T11:47:13.000000Z",
     *                          "id": 1
     *                    },
     *                    "access_token": "..."
     *               }
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
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name'     => 'required|max:55',
            'email'    => 'email|required|unique:users',
            'password' => 'required|confirmed',
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    /**
     * @OA\Post(
     *      path="/login/passport",
     *      operationId="login",
     *      tags={"Auth"},
     *      summary="Handle an incoming authentication request.",
     *      description="Logging in the user.",
     *      @OA\Parameter(
     *          name="email",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(property="token", type="string", format="string", example="..."),
     *          )
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email'    => 'email|required',
            'password' => 'required',
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);

    }

    public function loginShow()
    {
        return response()->json("Unauthorized", 401);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    /**
     * @OA\Post(
     *      path="/logout/passport",
     *      operationId="logout",
     *      tags={"Auth"},
     *      summary="Destroy an authenticated token.",
     *      description="Logging out the user.",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     * )
     */
    public function logoutApi()
    {
        if (Auth::check()) {
            Auth::user()->authAcessToken()->delete();
            return response()->json([], 200);
        }

        return response()->json("Unauthenticated", 401);
    }
}