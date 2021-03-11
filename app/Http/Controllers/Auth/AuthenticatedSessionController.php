<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    /**
     * @OA\Post(
     *      path="/login",
     *      operationId="login",
     *      tags={"Auth"},
     *      summary="Handle an incoming authentication request.",
     *      description="Logging in the user.",
     *      @OA\Parameter(
     *          name="email",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="email"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="password",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="password"
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
    public function store(LoginRequest $request)
    {
        //
//        $request->authenticate();
//
//        $request->session()->regenerate();
//
//        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    /**
     * @OA\Post(
     *      path="/logout",
     *      operationId="logout",
     *      tags={"Auth"},
     *      summary="Destroy an authenticated session.",
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
    public function destroy(Request $request)
    {
//        Auth::guard('web')->logout();
//
//        $request->session()->invalidate();
//
//        $request->session()->regenerateToken();
//
//        return redirect('/');

    }
}
