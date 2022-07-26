<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Mode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterCompanyRequest;
use App\Http\Requests\GetUsersRequest;
use App\Http\Requests\ModifyModeRequest;
use App\Http\Requests\GetUserByModeRequest;
use App\Http\Requests\GetUserByRoleRequest;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\EditUserEmailRequest;
use App\Http\Requests\EditUserPasswordRequest;
use App\Http\Requests\ChangeTokenRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\RateLimiter;

class UserController extends Controller
{


    ########################
    ### REGISTER COMPANY ###
    ########################

    public function registerCompany(RegisterCompanyRequest $request){
        try{
            $api_token = Str::random(60);
            $mode_id = Mode::where('name', $request->mode)->first()->id;
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'mode_id' => $mode_id,
                'requests' => 100,
                'api_token' => $api_token,
                'is_admin' => 0,
            ]);
            return response()->json(['status' => 1, 'user' => $user]);
        }
        catch(\Exception $e){
            return $e;
            return response()->json([
                'status' => 2,
                'message' => 'Failed to register your company',
            ]);
        }
    }


    #############
    ### LOGIN ###
    #############

    public function login(LoginRequest $request){
        try{
            $user = User::where('email', $request->email)->first();
            if(password_verify($request->password, $user->password)){
                return response()->json(['status' => 1, 'user' => $user]);
            }
            else{
                return response()->json([
                    'status' => 2,
                    'message' => 'Wrong password',
                ]);
            }
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'User does not exist',
            ]);
        }
    }


    #############################
    ### GET USER BY API TOKEN ###
    #############################

    public function user(GetUsersRequest $request){
        try{
            $user = User::where('api_token', $request->api_token)->first();
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'User does not exist',
            ]);
        }
        if($user->is_admin == 1){
            return response()->json(['status' => 1, 'user' => $user]);
        }
        else{
            return response()->json([
                'status' => 2,
                'message' => 'You do not have permissions to do this',
            ]);
        }
    }


    #################
    ### GET USERS ###
    #################

    public function users(GetUsersRequest $request){
        try{
            $user = User::where('api_token', $request->api_token)->first();
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'User does not exist',
            ]);
        }
        if($user->is_admin == 1){
            try{
                $users = DB::table('users')->get();
                return response()->json(['status' => 1, 'users' => $users]);
            }
            catch(\Exception $e){
                return response()->json([
                    'status' => 2,
                    'message' => 'There are no users',
                ]);
            }
        }
        else{
            return response()->json([
                'status' => 2,
                'message' => 'You do not have permissions to do this',
            ]);
        }
    }


    ########################
    ### CHANGE USER MODE ###
    ########################

    public function modifyMode(ModifyModeRequest $request){
        try{
            $user = User::where('api_token', $request->api_token)->first();
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'User does not exist',
            ]);
        }
        try{
            $mode = Mode::where('name', $request->mode)->first();
            $user->mode_id = $mode->id;
            $user->save();
            return response()->json(['status' => 1, 'user' => $user]);
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'Mode does not exist',
            ]);
        }
    }


    #########################
    ### GET USERS BY MODE ###
    #########################

    public function modes(GetUserByModeRequest $request){
        try{
            $user = User::where('api_token', $request->api_token)->first();
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'User does not exist',
            ]);
        }
        if($user->is_admin == 1){
            $users = DB::table('users')->where('mode_id', $request->mode_id)->get();
            return response()->json(['status' => 1, 'users' => $users]);
        }
        else{
            return response()->json([
                'status' => 2,
                'message' => 'You do not have permissions to do this',
            ]);
        }
    }


    #########################
    ### GET USERS BY ROLE ###
    #########################

    public function roles(GetUserByRoleRequest $request){
        try{
            $user = User::where('api_token', $request->api_token)->first();
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'User does not exist',
            ]);
        }
        if($user->is_admin == 1){
            $users = DB::table('users')->where('is_admin', $request->is_admin)->get();
            if(sizeOf($users) == 0){
                return response()->json([
                    'status' => 2,
                    'message' => 'There are no users',
                ]);
            }
            else{
                return response()->json(['status' => 1, 'users' => $users]);
            }
        }
        else{
            return response()->json([
                'status' => 2,
                'message' => 'You do not have permissions to do this',
            ]);
        }
    }


    ###################
    ### DELETE USER ###
    ###################

    public function deleteUser(DeleteUserRequest $request){
        try{
            $user = User::where('api_token', $request->api_token)->first();
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'User does not exist',
            ]);
        }
        try{
            $lists = DB::table('lists')->where('user_id', $user->id)->get();
            $lists_id = [];
            foreach($lists as $list){
                array_push($lists_id, $list->id);
            }
            foreach($lists_id as $list_id){
                DB::table('list_plate')->where('list_id', $list_id)->delete();
            }
            DB::table('lists')->where('user_id', $user->id)->delete();
            DB::table('sources')->where('user_id', $user->id)->delete();
            $user->delete();
            return response()->json(['status' => 1, 'message' => 'User deleted successfully']);
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'Failed to delete user',
            ]);
        }
    }


    #########################
    ### CHANGE USER EMAIL ###
    #########################

    public function editUserEmail(EditUserEmailRequest $request){
        try{
            $user = User::where('api_token', $request->api_token)->first();
            $user->email = $request->email;
            $user->save();
            return response()->json(['status' => 1, 'user' => $user]);
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'User does not exist',
            ]);
        }
    }


    ############################
    ### CHANGE USER PASSWORD ###
    ############################

    public function editUserPassword(EditUserPasswordRequest $request){
        try{
            $user = User::where('api_token', $request->api_token)->first();
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json(['status' => 1, 'user' => $user]);
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'User does not exist',
            ]);
        }
    }


    #############################
    ### CHANGE USER API TOKEN ###
    #############################

    public function changeApiToken(ChangeTokenRequest $request){
        try{
            $user = User::where('api_token', $request->api_token)->first();
            $user->api_token = Str::random(60);
            $user->save();
            return response()->json(['status' => 1, 'user' => $user]);
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'User does not exist',
            ]);
        }
    }
}
