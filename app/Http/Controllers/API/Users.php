<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Validator;
use App\User;

class Users extends Controller
{

    public function register(Request $request){
        $getData = $request->all();

        $response = $this->validateData($getData,[
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required',
            'c_password'=>'required|same:password'
        ]);
        
        if($response!==true){
            return $this->respondJson($response,[],422,0);
        }

        $getData['password']=bcrypt($getData['password']);
        $user=User::create($getData);
        $responseArray=[];
        $responseArray['token']=$user->createToken('loan-application')->accessToken;
        $responseArray['name']=$user['name'];
        return $this->respondJson('you are successfully registered with us.',$responseArray,200,1);
    }

    public function login(Request $request){
        $getData = $request->all();

        $response = $this->validateData($getData,[
            'email'=>'required',
            'password'=>'required'
        ]);

        if($response!==true){
            return $this->respondJson($response,[],422,0);
        }

        if(Auth::attempt(['email' =>$getData['email'], 'password' =>$getData['password']])){
            $user = Auth::user();
            $responseArray=[];
            $responseArray['token']=$user->createToken('myapp')->accessToken;
            $responseArray['name']=$user['name'];
            return $this->respondJson('',$responseArray,200,1);
        }else{
            return $this->respondJson('You have entered an invalid username or password.',[],202,0);
        }
    }
    public function unauthenticated(){
        return $this->respondJson('unauthnticated user.',[],401,0);
    }
}
