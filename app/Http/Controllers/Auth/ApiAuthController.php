<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use JWTAuth;
use JWTAuthException;
use App\User;

/**
 * Class ApiAuthController
 * @package App\Http\Controllers\Auth
 * authenticates a user per email and password data
 * it creates the jwt and passes an error message if the credentials are not ok
 */
class ApiAuthController extends Controller
{
    public function __construct()
    {
        $this->user = new User;
    }

    /**
     * check if credentials are ok and return token in response or error msg
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        //specify credential for login
        $credentials = $request->only('email', 'password');
        $jwt = '';
        try {
            //check if email and password are ok
            //response with 401 in case of invalid credentials
            if (!$jwt = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'response' => 'error',
                    'message' => 'invalid_credentials',
                ], 401);
            }
        } catch (JWTAuthException $e) {
            return response()->json([
                'response' => 'error',
                'message' => 'failed_to_create_token',
            ], 500);
        }
        //save token in result and return it
        return response()->json([
            'response' => 'success',
            'result' => ['token' => $jwt]
        ]);
    }

    /**
     * authenticates user with token sent as parameter (GET / POST)
     */
    public function getAuthUser(Request $request)
    {
        $user = JWTAuth::toUser($request->token);
        return response()->json(['result' => $user]);
    }

    /**
     * get current authenticated user - JWT must be set in HTTP header
     */
    public function getCurrentAuthenticatedUser()
    {
        $user = JWTAuth::user();
        return response()->json(['result' => $user]);
    }

    /**
     * invalidate token and logout
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function logout()
    {
        JWTAuth::invalidate();
        return response([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }
}
