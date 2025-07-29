<?php

namespace App\Http\Controllers;

//use JWTAuth;
use Tymon\JWTAuth\Facades\JWTAuth;
//use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use DB;

class ApiController extends Controller
{
    // protected $user;

    public function __construct()
    {
        // $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function register(Request $request)
    {
        //Validate data
        $data = $request->only('name', 'email', 'password');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        //User created, return success response
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ], Response::HTTP_OK);
    }

    public function authenticate(Request $request)
    {
		$cust_email = $request->email;


        $credentials = $request->only('email', 'password');
        //$credentials = $request->only('mobile');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
			//Request is validated
			//Crean token
		try {
			if (! $token = JWTAuth::attempt($credentials)) {
				return response()->json([
					'success' => false,
					'message' => 'Invalid credentials',
				], 200);
			}
			$user = User::where('email', $cust_email)->first();
			//Token created, return with success response and jwt token
			return response()->json([
				'success' => true,
				'token' => $token,
				'data' => $user,
			]);
		} catch (JWTException $e) {
			return $credentials;
			return response()->json([
					'success' => false,
					'message' => 'Oops! Something Went Wrong,  Please Try Again',
				], 200);
		}
    }

    public function logout(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated, do logout
        try {
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function get_user(Request $request)
    {
        // $this->validate($request, [
        //     'token' => 'required'
        // ]);
        $user = JWTAuth::parseToken()->authenticate();
        // $user = JWTAuth::authenticate($request->token);

        return response()->json(['user' => $user]);
    }
}
