<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
     public function aunathorized(){
        return response()->json(['Você não tem permissão para acesssar essa página.'], 401);
     }

    public function register(Request $request){

        $array = ['error' => ''];
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'cpf' => 'required|digits:11|unique:users,cpf',
            'password' => 'required',
            'password_comfirmed' => 'required|same:password',
        ]);

        if($validator->fails())
        {
            return $array['validatorErrors'] = $validator->errors()->first();
        }

        $newUser = new User();
        $newUser->name = $request->input('name');
        $newUser->email = $request->input('email');
        $newUser->cpf = $request->input('cpf');
        $newUser->password = password_hash($request->input('password'), PASSWORD_DEFAULT);
        $newUser->save();
        
        $token = auth()->attempt([
            'cpf' => $request->input('cpf'),
            'password' => $request->input('password'),
        ]);

        if(!$token){
           return $array['internalError'] = 'Ocorreu um erro interno.';
        }

        $array['user'] = auth()->user();
        $array['user']['porperties'] = Unit::select('id', 'name')->where('id_woner', auth()->user()->id);
        $array['token'] = $token;

        return $array;
    }

    public function login(Request $request){
        $array = ['error' => ''];

        $validator = Validator::make($request->all(), [
            'cpf' => 'required|digits:11',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return $array['validatorErrors'] = $validator->errors()->first();
        }

        $token = auth()->attempt([
            'cpf' => $request->input('cpf'),
            'password' => $request->input('password'),
        ]);

        if(!$token){
           return $array['internalError'] = 'Ocorreu um erro interno.';
        }

        $array['user'] = auth()->user();
        $array['user']['porperties'] = Unit::select('id', 'name')->where('id_woner', auth()->user()->id);
        $array['token'] = $token;

        return $array;
    }

    public function validateToken(){

        $array = ['error' => ''];

        $array['user'] = auth()->user();
        $array['user']['porperties'] = Unit::select('id', 'name')->where('id_woner', auth()->user()->id);

        return $array;
    }

    public function logout(){

        $array = ['error' => ''];
        auth()->logout();
        
        return $array;
    }
}
