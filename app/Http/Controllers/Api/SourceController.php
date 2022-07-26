<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Source;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\GetSourcesRequest;
use App\Http\Requests\CreateSourceRequest;
use App\Http\Requests\DeleteSourceRequest;
use App\Http\Requests\EditSourceRequest;

class SourceController extends Controller
{


    ############################
    ### CREATE SOURCE MODE 3 ###
    ############################

    public function createSourceMode3(CreateSourceRequest $request){
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
            if($user->mode_id == 3){
                $sources = DB::table('sources')->where('user_id', $user->id)->get();
                foreach($sources as $source){
                    if($source->latitude == $request->latitude && $source->longitude == $request->longitude){
                        return response()->json([
                            'status' => 2,
                            'message' => 'A source with those coordinates already exists',
                        ]);
                    }
                    if($source->name == $request->name){
                        return response()->json([
                            'status' => 2,
                            'message' => 'A source with that name already exists',
                        ]);
                    }
                }
                try{
                    $source = Source::create([
                        'name' => $request->name,
                        'description' => $request->description,
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude,
                        'user_id' => $user->id,
                    ]);
                    $source->save();
                    return response()->json(['status' => 1, 'source' => $source]);
                }
                catch(\Exception $e){
                    return response()->json([
                        'status' => 2,
                        'message' => 'Failed to create source',
                    ]);
                }
            }
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'Failed to create source',
            ]);
        }
    }


    ############################
    ### CREATE SOURCE MODE 4 ###
    ############################

    public function createSourceMode4(CreateSourceRequest $request){
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
            if($user->mode_id == 4){
                $sources = DB::table('sources')->where('user_id', $user->id)->get();
                foreach($sources as $source){
                    if($source->latitude == $request->latitude && $source->longitude == $request->longitude){
                        return response()->json([
                            'status' => 2,
                            'message' => 'A source with those coordinates already exists',
                        ]);
                    }
                    if($source->name == $request->name){
                        return response()->json([
                            'status' => 2,
                            'message' => 'A source with that name already exists',
                        ]);
                    }
                }
                try{
                    $source = Source::create([
                        'name' => $request->name,
                        'description' => $request->description,
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude,
                        'user_id' => $user->id,
                    ]);
                    $source->save();
                    return response()->json(['status' => 1, 'source' => $source]);
                }
                catch(\Exception $e){
                    return response()->json([
                        'status' => 2,
                        'message' => 'Failed to create source',
                    ]);
                }
            }
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'Failed to create source',
            ]);
        }
    }


    #################################
    ### DENY CREATE SOURCE MODE 1 ###
    #################################

    public function createSourceMode1(Request $request){
        try{
            $user = User::where('api_token', $request->api_token)->first();
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'User does not exist',
            ]);
        }
        if($user->mode_id == 1){
            return response()->json([
                'status' => 2,
                'message' => 'You do not have permissions to create a source',
            ]);
        }
    }


    #################################
    ### DENY CREATE SOURCE MODE 2 ###
    #################################

    public function createSourceMode2(Request $request){
        try{
            $user = User::where('api_token', $request->api_token)->first();
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'User does not exist',
            ]);
        }
        if($user->mode_id == 2){
            return response()->json([
                'status' => 2,
                'message' => 'You do not have permissions to create a source',
            ]);
        }
    }


    ###################
    ### GET SOURCES ###
    ###################

    public function sources(GetSourcesRequest $request){
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
            $sources = DB::table('sources')->where('user_id', $user->id)->get();
            if(sizeOf($sources) == 0){
                return response()->json([
                    'status' => 2,
                    'message' => 'There are no sources',
                ]);
            }
            else{
                return response()->json(['status' => 1, 'sources' => $sources]);
            }
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'Sources could not be displayed',
            ]);
        }
    }


    ############################
    ### DELETE SOURCE MODE 3 ###
    ############################

    public function deleteSourceMode3(DeleteSourceRequest $request){
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
            if($user->mode_id == 3){
                try{
                    $source = Source::where('name', $request->name)->where('user_id', $user->id)->first();
                    if($source == null){
                        return response()->json([
                            'status' => 2,
                            'message' => 'Source does not exist',
                        ]);
                    }
                    else{
                        $source->delete();
                        return response()->json(['status' => 1, 'source' => 'Source deleted successfully']);
                    }
                }
                catch(\Exception $e){
                    return response()->json([
                        'status' => 2,
                        'message' => 'Failed to delete source',
                    ]);
                }
            }
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'Failed to delete source',
            ]);
        }
    }


    ############################
    ### DELETE SOURCE MODE 4 ###
    ############################

    public function deleteSourceMode4(DeleteSourceRequest $request){
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
            if($user->mode_id == 4){
                try{
                    $source = Source::where('name', $request->name)->where('user_id', $user->id)->first();
                    if($source == null){
                        return response()->json([
                            'status' => 2,
                            'message' => 'Source does not exist',
                        ]);
                    }
                    else{
                        $source->delete();
                        return response()->json(['status' => 1, 'source' => 'Source deleted successfully']);
                    }
                }
                catch(\Exception $e){
                    return response()->json([
                        'status' => 2,
                        'message' => 'Failed to delete source',
                    ]);
                }
            }
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'Failed to delete source',
            ]);
        }
    }


    #################################
    ### DENY DELETE SOURCE MODE 1 ###
    #################################

    public function deleteSourceMode1(Request $request){
        try{
            $user = User::where('api_token', $request->api_token)->first();
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'User does not exist',
            ]);
        }
        if($user->mode_id == 1){
            return response()->json([
                'status' => 2,
                'message' => 'You do not have permissions to delete a source',
            ]);
        }
    }


    #################################
    ### DENY DELETE SOURCE MODE 2 ###
    #################################

    public function deleteSourceMode2(Request $request){
        try{
            $user = User::where('api_token', $request->api_token)->first();
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'User does not exist',
            ]);
        }
        if($user->mode_id == 2){
            return response()->json([
                'status' => 2,
                'message' => 'You do not have permissions to delete a source',
            ]);
        }
    }


    ##########################
    ### EDIT SOURCE MODE 3 ###
    ##########################

    public function editSourceMode3(EditSourceRequest $request){
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
            if($user->mode_id == 3){
                try{
                    $source = Source::where('name', $request->source_name)->where('user_id', $user->id)->first();
                    if($source == null){
                        return response()->json([
                            'status' => 2,
                            'message' => 'Source does not exist',
                        ]);
                    }
                    if($request->name != null){
                        $source->name = $request->name;
                    }
                    if($request->description != null){
                        $source->description = $request->description;
                    }
                    if($request->latitude != null){
                        $source->latitude = $request->latitude;
                    }
                    if($request->longitude != null){
                        $source->longitude = $request->longitude;
                    }
                    $source->save();
                    return response()->json(['status' => 1, 'source' => $source]);
                }
                catch(\Exception $e){
                    return response()->json([
                        'status' => 2,
                        'message' => 'Failed to edit source',
                    ]);
                }
            }
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'Failed to edit source',
            ]);
        }
    }


    ##########################
    ### EDIT SOURCE MODE 4 ###
    ##########################

    public function editSourceMode4(EditSourceRequest $request){
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
            if($user->mode_id == 4){
                try{
                    $source = Source::where('name', $request->source_name)->where('user_id', $user->id)->first();
                    if($source == null){
                        return response()->json([
                            'status' => 2,
                            'message' => 'Source does not exist',
                        ]);
                    }
                    if($request->name != null){
                        $source->name = $request->name;
                    }
                    if($request->description != null){
                        $source->description = $request->description;
                    }
                    if($request->latitude != null){
                        $source->latitude = $request->latitude;
                    }
                    if($request->longitude != null){
                        $source->longitude = $request->longitude;
                    }
                    $source->save();
                    return response()->json(['status' => 1, 'source' => $source]);
                }
                catch(\Exception $e){
                    return response()->json([
                        'status' => 2,
                        'message' => 'Failed to edit source',
                    ]);
                }
            }
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'Failed to edit source',
            ]);
        }
    }


    ###############################
    ### DENY EDIT SOURCE MODE 1 ###
    ###############################

    public function editSourceMode1(Request $request){
        try{
            $user = User::where('api_token', $request->api_token)->first();
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'User does not exist',
            ]);
        }
        if($user->mode_id == 1){
            return response()->json([
                'status' => 2,
                'message' => 'You do not have permissions to edit a source',
            ]);
        }
    }


    ###############################
    ### DENY EDIT SOURCE MODE 2 ###
    ###############################

    public function editSourceMode2(Request $request){
        try{
            $user = User::where('api_token', $request->api_token)->first();
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'User does not exist',
            ]);
        }
        if($user->mode_id == 2){
            return response()->json([
                'status' => 2,
                'message' => 'You do not have permissions to edit a source',
            ]);
        }
    }
}
