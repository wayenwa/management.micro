<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\DB;
use App\Location;
use App\Http\Traits\AuthsTrait;
use App\Http\Traits\LocationsTrait;
use App\Http\Traits\ScheduleTimingsTrait;

class LocationsController extends BaseController
{
    use AuthsTrait;
    use LocationsTrait;
    use ScheduleTimingsTrait;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $locations = $this->retrieveActiveLocationList();
        
        $result = [
            'data'      =>  $locations,
            'schedules' =>  $this->scheduleTimingList()
        ];
        return $this->sendResponse($result, 'Location retrieved successfully.');
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
            'location' => 'required',
            'permission' => 'required',
            'login_token' => 'required',
        ]);

        $user = $this->getUserByLoginToken($data['login_token']);

        if(!$user || $user->user_type != USER_TYPE_SUPER_ADMIN){
            return response()->json(['message' => 'Access expired.'], 401);
        }

        if(!$this->checkPermission($data['permission'])){
            return response()->json(['message' => 'Permission not valid.'], 401);
        }

        $input = array(
            'location'      =>  $request->json('municipality'),
            'status'        =>  STATUS_ENABLED,
            'created_by'    =>  $user->id,
        );

        if(!Location::create($input))
            return response()->json(['message' => 'Permission not valid.'], 401);
        else
            $locations = Location::active()->get();

            return $this->sendResponse($this->retrieveActiveLocationList(), 'Location created successfully.');
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