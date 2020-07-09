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
        $validator = Validator::make($data, [
            'data' => 'required',
            'login_token' => 'required',
        ]);

        $user = $this->getUserByLoginToken($data['login_token']);

        $data = $data['data'];

        $input = array(
            'name'      =>  $data['schedule_name'],
            'mon'       =>  $data['days']['mon'],     
            'tue'       =>  $data['days']['tue'],
            'wed'       =>  $data['days']['wed'],
            'thu'       =>  $data['days']['thu'],
            'fri'       =>  $data['days']['fri'],
            'sat'       =>  $data['days']['sat'],
            'sun'       =>  $data['days']['sun'],
            'from'      =>  $data['from'],
            'to'        =>  $data['to'],
            'created_by'=>  $user->id
        );

        if(!ScheduleTiming::create($input))
            return response()->json(['message' => 'Failed to save'], 422);
        else
            $scheds = ScheduleTiming::orderBy('name', 'asc')->get();

            return $this->sendResponse($scheds, 'Schedules created successfully.');
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