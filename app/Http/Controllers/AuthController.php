<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\Providers\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;

        $this->validate($request, [
            'name'=> 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:255'
        ]);

        try{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = app('hash')->make($request->password);
            if($user->save()){
                return $this->login($request);
            }
        }catch(\Exception $e){
                return response()->json(['status'=>'Error', 'message'=>$e->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        try{
            //auth()->logout(true);
            $token =  $request->header('Authorization');
            auth()->invalidate($token);
            //Auth::logout();
            //auth()->invalidate('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvbG9naW4iLCJpYXQiOjE2MzkzMTg5MjMsImV4cCI6MTYzOTMyMjUyMywibmJmIjoxNjM5MzE4OTIzLCJqdGkiOiJJeTkxa2FVdG9Nd3dTeW1aIiwic3ViIjoxLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.pLia0V8wAxrtLe8g-w898pL2gyfWcHb6psflIHFPGFA');

            //JWTAuth::invalidate($request->token);
            
            return response()->json(['status'=> 'Success', 'message'=> $token]);
        }catch(\Exception $e){
            return response()->json(['status'=>'Error', 'message'=>$e->getMessage()]);
        }
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        if(empty($email) or empty($password)){
            return response()->json(['status'=>'Error', 'message'=>'Please fill in all fields']);
        }

        $credentials = request(['email', 'password']);
        if(! $token = auth()->attempt($credentials)){
            return response()->json(['error'=>'Unauthorized', 'code'=>401]);
        }

        return $this->respondWithToken($token);
    }
    
    
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }


}
