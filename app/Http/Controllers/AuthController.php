<?php

namespace App\Http\Controllers;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use Auth;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required|unique:users|min:5',
    		'email' => 'required|unique:users',
    		'password' => 'required|min:5',
    	]);

    	$user = User::create([
    		'name' => $request->name,
    		'email' => $request->email,
    		'password' => bcrypt($request->password),
    	]);

    	return response()->json($user);
    }

    public function signin(Request $request)
    {
    	$this->validate($request, ['email' => 'required', 'password' => 'required', ]);
    	// grab credentials from the request
        $credentials = $request->only('email', 'password');
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json([
        	'user' => $request->user(),
        	'token' => $token
        ], 200);
    }

    public function infoUser(Request $request)
    {
    	if (Auth::user())
        {
            $data = Auth::user();
            return response()->json([
            	'data' => $data
            ], 200);
        }
    }

    public function signout(Request $request)
    {
    	return JWTAuth::invalidate();
    }

}
