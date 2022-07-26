<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index(){
        if(Auth::check()){
            $api_token = Auth::user()->api_token;
            return view('backend/logged', compact('api_token'));
        }
        else{
            return view('backend/login');
        }
    }

    public function register(){
        try{
            $modes = DB::table('modes')->get();
            if(Auth::check()){
                $api_token = Auth::user()->api_token;
                return view('backend/logged', compact('api_token'));
            }
            else{
                return view('backend/register', compact('modes'));
            }
        }
        catch(\Exception $e){
            echo $e;
        }
    }

    public function handleRegister(Request $request){
        try{
            $name = $request->input('name');
            $email = $request->input('email');
            $mode = $request->input('mode');
            $api_token = Str::random(60);

            $user = User::create([
                'name' => $name,
                'email' => $email,
                'mode_id' => $mode,
                'api_token' => $api_token,
            ]);
            Auth::login($user);
            return view('backend/logged', compact('api_token'));
        }
        catch(\Exception $e){
            return redirect()->back()->withErrors(['msg' => $e]);
        }
    }

    public function handleLogin(Request $request){
        try{
            $email = $request->input('email');
            $api_token = $request->input('token');
            $user = User::where('email', $email)->where('api_token', $api_token)->first();
            Auth::login($user);
            return view('backend/logged', compact('api_token'));
        }
        catch(\Exception $e){
            return redirect()->back()->withErrors(['msg' => $e]);
        }
    }
}
