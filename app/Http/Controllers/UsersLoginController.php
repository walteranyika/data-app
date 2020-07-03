<?php

namespace App\Http\Controllers;

use App\Responses\Responses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsersLoginController extends Controller
{
    use Responses;
    public function userLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
            'password' => 'required|string',
        ]);
        $errors = $validator->messages();
        if ($validator->fails()) {
            return $this->sendFailureResponse($errors);
        }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            return $this->sendSuccessResponse($user);
        }
        else{
            return $this->sendFailureResponse("Wrong username or password");
        }
    }
}
