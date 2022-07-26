<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Plate;
use App\Models\PlatesList;
use App\Models\User;
use App\Models\ListPlate;
use App\Models\SavedPlate;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CreateDeleteListRequest;
use App\Http\Requests\AddRemovePlateToListRequest;
use App\Http\Requests\GetListsRequest;
use App\Http\Requests\GetPlatesInListRequest;
use App\Http\Requests\GetPlateRequest;
use App\Http\Requests\GetListOfPlateRequest;

class LicensePlatesController extends Controller
{


    #########################
    ### ADD PLATE TO LIST ###
    #########################

    public function addPlateToList(AddRemovePlateToListRequest $request){
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
            $plate = Plate::where('number', $request->number)->first();
            $list = PlatesList::where('name', $request->list_name)->where('user_id', $user->id)->first();
            if($plate == null){
                $plate = Plate::create([
                    'number' => $request->number,
                ]);
            }
            if ($list == null){
                return response()->json([
                    'status' => 2,
                    'message' => 'The list does not exist',
                ]);
            }
            else if(ListPlate::where('list_id', $list->id)->where('plate_id', $plate->id)->first() == null){
                $list_plate = ListPlate::create([
                    'list_id' => $list->id,
                    'plate_id' => $plate->id,
                ]);
                return response()->json(['status' => 1, 'message' => 'License plate '.$plate->number.' has been added to list '.$list->name]);
            }
            else{
                return response()->json([
                    'status' => 2,
                    'message' => 'License plate is already on this list',
                ]);
            }
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'Failed to add license plate to list',
            ]);
        }
    }


    ###################
    ### CREATE LIST ###
    ###################

    public function createList(CreateDeleteListRequest $request){
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
            foreach($lists as $list){
                if($list->name == $request->name){
                    return response()->json([
                        'status' => 2,
                        'message' => 'A list with that name already exists',
                    ]);
                }
            }
            $list = PlatesList::create([
                'name' => $request->name,
                'description' => $request->description,
                'user_id' => $user->id,
            ]);
            $list->save();
            return response()->json(['status' => 1, 'list' => $list]);
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'Failed to create list',
            ]);
        }
    }


    ##############################
    ### REMOVE PLATE FROM LIST ###
    ##############################

    public function removePlateFromList(AddRemovePlateToListRequest $request){
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
            $plate = Plate::where('number', $request->number)->first();
            if($plate == null){
                $plate = Plate::create([
                    'number' => $request->number,
                ]);
            }
            $list = PlatesList::where('name', $request->list_name)->where('user_id', $user->id)->first();
            if ($list == null){
                return response()->json([
                    'status' => 2,
                    'message' => 'List does not exist',
                ]);
            }
            $list_plate = ListPlate::where('list_id', $list->id)->where('plate_id', $plate->id)->first();
            if($list_plate == null){
                return response()->json([
                    'status' => 2,
                    'message' => 'License plate is not in the list',
                ]);
            }
            else{
                $list_plate->delete();
                return response()->json(['status' => 1, 'message' => 'License plate '.$plate->number.' has been removed from list '.$list->name]);
            }
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'Failed to remove license plate from list',
            ]);
        }
    }


    ###################
    ### DELETE LIST ###
    ###################

    public function deleteList(CreateDeleteListRequest $request){
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
            $list = PlatesList::where('name', $request->name)->where('user_id', $user->id)->first();
            if($list == null){
                return response()->json([
                    'status' => 2,
                    'message' => 'List does not exist',
                ]);
            }
            else{
                DB::table('list_plate')->where('list_id', $list->id)->delete();
                $list->delete();
            }
            return response()->json(['status' => 1, 'message' => 'List deleted successfully']);
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'Failed to delete list',
            ]);
        }
    }


    #################
    ### GET LISTS ###
    #################

    public function lists(GetListsRequest $request){
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
            if(sizeOf($lists) == 0){
                return response()->json([
                    'status' => 2,
                    'message' => 'There are no lists',
                ]);
            }
            else{
                return response()->json(['status' => 1, 'lists' => $lists]);
            }
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'Lists could not be displayed',
            ]);
        }
    }


    ##########################
    ### GET PLATES IN LIST ###
    ##########################

    public function platesInList(GetPlatesInListRequest $request){
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
            $list = DB::table('lists')->where('name', $request->list_name)->where('user_id', $user->id)->first();
            if($list == null){
                return response()->json([
                    'status' => 2,
                    'message' => 'List does not exist',
                ]);
            }
            $list_plates = DB::table('list_plate')->where('list_id', $list->id)->get();
            if(sizeOf($list_plates) == 0){
                return response()->json([
                    'status' => 2,
                    'message' => 'There are no license plates in this list',
                ]);
            }
            else{
                $plates_id = [];
                foreach($list_plates as $list_plate){
                    array_push($plates_id, $list_plate->plate_id);
                }
                $plates = DB::table('plates')->whereIn('id', $plates_id)->get();
                return response()->json(['status' => 1, 'plates' => $plates]);
            }
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'License plates could not be displayed',
            ]);
        }
    }


    ########################
    ### GET PLATE MODE 2 ###
    ########################

    public function plateMode2(GetPlateRequest $request){
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
            $plate = Plate::where('number', $request->number)->first();
            if($plate == null){
                $plate = Plate::create([
                    'number' => $request->number,
                ]);
            }
            else{
                if($user->mode_id == 2){
                    $saved_plate = SavedPlate::where('number', $request->number)->where('user_id', $user->id)->first();
                    if($saved_plate == null){
                        if($user->requests > 0){
                            $saved_plate = SavedPlate::create([
                                'number' => $request->number,
                                'user_id' => $user->id,
                            ]);
                            $saved_plate->save();
                            $user->requests -= 1;
                            $user->save();
                            return response()->json(['status' => 1, 'plate' => $plate]);
                        }
                        else{
                            return response()->json([
                                'status' => 2,
                                'message' => 'Maximum number of requests have been reached',
                            ]);
                        }
                    }
                    else{
                        return response()->json(['status' => 1, 'plate' => $plate]);
                    }
                }
            }
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'Plate could not be displayed',
            ]);
        }
    }


    ########################
    ### GET PLATE MODE 4 ###
    ########################

    public function plateMode4(GetPlateRequest $request){
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
            $plate = Plate::where('number', $request->number)->first();
            if($plate == null){
                $plate = Plate::create([
                    'number' => $request->number,
                ]);
            }
            else{
                if($user->mode_id == 4){
                    $saved_plate = SavedPlate::where('number', $request->number)->where('user_id', $user->id)->first();
                    if($saved_plate == null){
                        if($user->requests > 0){
                            $saved_plate = SavedPlate::create([
                                'number' => $request->number,
                                'user_id' => $user->id,
                            ]);
                            $saved_plate->save();
                            $user->requests -= 1;
                            $user->save();
                            return response()->json(['status' => 1, 'plate' => $plate]);
                        }
                        else{
                            return response()->json([
                                'status' => 2,
                                'message' => 'Maximum number of requests have been reached',
                            ]);
                        }
                    }
                    else{
                        return response()->json(['status' => 1, 'plate' => $plate]);
                    }
                }
            }
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'Plate could not be displayed',
            ]);
        }
    }


    ########################
    ### GET PLATE MODE 1 ###
    ########################

    public function plateMode1(GetPlateRequest $request){
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
            $plate = Plate::where('number', $request->number)->first();
            if($plate == null){
                $plate = Plate::create([
                    'number' => $request->number,
                ]);
            }
            else{
                if($user->mode_id == 1){
                    if($user->requests > 0){
                        $user->requests -= 1;
                        $user->save();
                        return response()->json(['status' => 1, 'plate' => $plate]);
                    }
                    else{
                        return response()->json([
                            'status' => 2,
                            'message' => 'Maximum number of requests have been reached',
                        ]);
                    }
                }
            }
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'Plate could not be displayed',
            ]);
        }
    }


    ########################
    ### GET PLATE MODE 3 ###
    ########################

    public function plateMode3(GetPlateRequest $request){
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
            $plate = Plate::where('number', $request->number)->first();
            if($plate == null){
                $plate = Plate::create([
                    'number' => $request->number,
                ]);
            }
            else{
                if($user->mode_id == 3){
                    if($user->requests > 0){
                        $user->requests -= 1;
                        $user->save();
                        return response()->json(['status' => 1, 'plate' => $plate]);
                    }
                    else{
                        return response()->json([
                            'status' => 2,
                            'message' => 'Maximum number of requests have been reached',
                        ]);
                    }
                }
            }
        }
        catch(\Exception $e){
            return response()->json([
                'status' => 2,
                'message' => 'Plate could not be displayed',
            ]);
        }
    }


    #########################
    ### GET LIST OF PLATE ###
    #########################

    public function listOfPlate(GetListOfPlateRequest $request){
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
            $plate = Plate::where('number', $request->number)->first();
            if($plate == null){
                $plate = Plate::create([
                    'number' => $request->number,
                ]);
                return response()->json(['status' => 1, 'message' => 'The car is not in any list']);
            }
            $lists = PlatesList::where('user_id', $user->id)->get();
            $list_plates = [];
            foreach($lists as $list){
                array_push($list_plates, ListPlate::where('list_id', $list->id)->get());
            }
            for($i = 0; $i < count($list_plates); $i++){
                for($j = 0; $j < count($list_plates[$i]); $j++){
                    if(intval($list_plates[$i][$j]->plate_id) == $plate->id){
                        $list_plate = ListPlate::where('list_id', intval($list_plates[$i][$j]->list_id))->first();
                        $list = PlatesList::where('id', $list_plate->list_id)->first();
                        return response()->json(['status' => 1, 'message' => 'License plate '.$plate->number.' is in '.$list->name.' list']);
                    }
                }
            }
            return response()->json(['status' => 1, 'message' => 'The car is not in any list']);
        }
        catch(\Exception $e){
            return response()->json(['status' => 2, 'message' => 'License plate is not registered']);
        }
    }
}
