<?php
 
namespace App\Http\Controllers\API;
 
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\User;
 
class RegisterController extends BaseController
{
    /**
     * Registration Req
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
 
        $token = $user->createToken('RandomKeyPassportAuth')->accessToken;
 
        return $this->sendResponse(['token' => $token], 'Registered successfully.');
    }
 
    /**
     * Login Req
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('RandomKeyPassportAuth')->accessToken;
            return $this->sendResponse(['token' => $token], 'Registered successfully.');
        } else {
            return $this->sendError(['error' => 'Unauthorised'], "Login Failed". 401);
        }
    }
 
    public function userInfo()
    {
     $user = auth()->user();
 
     return $this->sendResponse(['user' => $user], 'User retrieved successfully.');
    }
}