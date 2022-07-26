<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Mode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\GetModesRequest;
use App\Http\Requests\CreateModeRequest;
use App\Http\Requests\DeleteModeRequest;

class ModeController extends Controller
{


    ###################
    ### CREATE MODE ###
    ###################

    public function createMode(CreateModeRequest $request){
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
                $mode = Mode::create([
                    'name' => $request->name,
                    'cache' => $request->cache,
                    'sources' => $request->sources,
                ]);
                $mode->save();
                return response()->json(['status' => 1, 'mode' => $mode]);
            }
            catch(\Exception $e){
                return response()->json([
                    'status' => 2,
                    'message' => 'Failed to create mode',
                ]);
            }
        }
        else {
            return response()->json([
                'status' => 2,
                'message' => 'You do not have permissions to create a mode',
            ]);
        }
    }


    #################
    ### GET MODES ###
    #################

    public function modes(GetModesRequest $request){
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
            $modes = DB::table('modes')->get();
            if(sizeOf($modes) == 0){
                return response()->json([
                    'status' => 2,
                    'message' => 'There are no modes',
                ]);
            }
            else{
                return response()->json(['status' => 1, 'modes' => $modes]);
            }
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'Modes could not be displayed',
            ]);
        }
    }


    ###################
    ### DELETE MODE ###
    ###################

    public function deleteMode(DeleteModeRequest $request){
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
                $mode = Mode::where('name', $request->name)->first();
                $users = DB::table('users')->where('mode_id', $mode->id)->get();
                if(sizeOf($users) == 0){
                    $mode->delete();
                    return response()->json(['status' => 1, 'message' => 'Mode deleted successfully']);
                }
                else{
                    return response()->json([
                        'status' => 2,
                        'message' => 'Mode could not be deleted, there are users with that mode',
                    ]);
                }
            }
            catch(\Exception $e){
                return response()->json([
                    'status' => 2,
                    'message' => 'Failed to delete mode',
                ]);
            }
        }
        else {
            return response()->json([
                'status' => 2,
                'message' => 'You do not have permissions to delete a mode',
            ]);
        }
    }
}
