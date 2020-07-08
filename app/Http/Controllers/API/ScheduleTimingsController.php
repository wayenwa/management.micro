<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\DB;
use App\ScheduleTiming;
use App\Http\Traits\AuthsTrait;
use App\Http\Traits\SchedulesTrait;

class ScheduleTimingsController extends BaseController
{
    use AuthsTrait;
    use SchedulesTrait;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $scheds = ScheduleTiming::all();
        
        return $this->sendResponse($scheds, 'Schedules retrieved successfully.');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $data = $request->json()->all();

        // $validator = Validator::make($data, [
        //     'location' => 'required',
        //     'permission' => 'required',
        //     'login_token' => 'required',
        // ]);

        // $user = $this->getUserByLoginToken($data['login_token']);

        // if(!$this->checkPermission($data['permission'])){
        //     return response()->json(['message' => 'Permission not valid.'], 422);
        // }

        // $input = array(
        //     'location'      =>  $request->json('municipality'),
        //     'status'        =>  STATUS_ENABLED,
        //     'created_by'    =>  $user->id,
        // );

        // if(!Location::create($input))
        //     return response()->json(['message' => 'Permission not valid.'], 422);
        // else
        //     $locations = Location::active()->get();

        //     return $this->sendResponse($this->retrieveActiveLocationList(), 'Location created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        $location->delete();

        return $this->sendResponse($this->retrieveActiveLocationList(), 'Location deleted successfully.');
    }
}