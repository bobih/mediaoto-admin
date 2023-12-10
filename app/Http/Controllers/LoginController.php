<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use \Firebase\JWT\JWT;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:4|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 401);
        }

        $email = $request['email'];
        $password = $request['password'];
        $user = User::where('email', $email)->first();
        $pwd_verify = password_verify($password, $user['password']);

        if($pwd_verify == false){
            return response()->json(['error' => "Password Error"], 401);
        }

        $key = getenv('JWT_SECRET');
        $iat = time(); // current timestamp value
        $exp = $iat + 36000;
        $payload = array(
            "iss" => "mediaoto",
            "aud" => "mobile",
            "sub" => "api",
            "iat" => $iat, //Time the JWT issued at
            "exp" => $exp, // Expiration time of token
            "email" => $request['email'],
        );
        $token = JWT::encode($payload, $key, 'HS256');

        $data = [ 'success' => true,
        'id'    => $user->id,
        'token' => $token];
        array_walk_recursive($data, function (&$item) {
            $item = strval($item);
        });

        return response()->json($data, 200);
    }

    public function refreshToken(Request $request)
    {

        $email = $request['email'];

        $user = User::where('email', $email)->first();

        if($user == null){
            return response()->json(["Error" => "User Not Found"], 200);
        }

        $key = getenv('JWT_SECRET');
        $iat = time(); // current timestamp value
        $exp = $iat + 3600;
        //$exp = $iat + 60; // Test 1 minutes

        $payload = array(
            "iss" => "mediaoto",
            "aud" => "mobile",
            "sub" => "api",
            "iat" => $iat, //Time the JWT issued at
            "exp" => $exp, // Expiration time of token
            "email" => $email,
        );

        $token = JWT::encode($payload, $key, 'HS256');
        $response = [
            'message' => 'Refresh Succesful',
            'token' => $token
        ];

        return response()->json($response, 200);
    }
}
