<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Validator;
use App\User;

class AuthController extends Controller
{
    /**
     * The user repository instance.
     *
     * @var \App\Repositories\UserRepositoryInterface
     */
    protected $user;

    /**
     * Create a new AuthController instance.
     *
     * @param \App\Repositories\UserRepositoryInterface $user
     * @return void
     */
    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
        $this->middleware('jwt.auth', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:225|unique:users,email',
            'fullname' => 'required',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json([
                'status' => true,
                'message' => $validator->errors()->all()
            ], 400);
        }

        $user = $this->user->store([
            'email'    => $request->input('email'),
            'fullname' => $request->input('fullname'),
            'password' => $request->input('password'),
        ]);

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }


    /**
     * Get a JWT via given credentials.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:225',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json([
                'status' => true,
                'message' => $validator->errors()->all()
            ], 400);
        }

        $credentials = $request->only('email', 'password');
        try{
            if (! $token = auth()->attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }
        }catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e){

            return response()->json(['status' => false,
                'message' => 'token_expired'
            ], 500);

        }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){

            return response()->json(['status' => false,
                'message' => 'token_invalid'
            ], 500);

        }catch (\Tymon\JWTAuth\Exceptions\JWTException $e){

            return response()->json(['status' => false,
                'message' => 'token_absent: '.$e->getMessage()
            ], 500);

        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'status' => true,
            'message' => 'Successfully logged out',
            'data' => null
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    /**
     * Get current loggedIn user
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser(){
        return response()->json([
            'status' => true,
            'message' => null,
            'data' => auth()->user()
        ]);
    }
}
