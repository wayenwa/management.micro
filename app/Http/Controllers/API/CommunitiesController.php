<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Traits\AuthsTrait;
use App\Http\Traits\LocationsTrait;
use App\Community;
use App\Location;

class CommunitiesController extends BaseController
{
    use AuthsTrait;
    use LocationsTrait;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $category = $this->retrieveActiveLocationList();
        return $this->sendResponse($category->toArray(), 'Location retrieved successfully.');
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
            'data'                => 'required',
            'location_id'         => 'required|integer',
            'login_token'         => 'required',
        ]);

        $user = $this->getUserByLoginToken($data['login_token']);

        $input = array(
            'location_id'           =>  $data['location_id'],
            'status'                =>  STATUS_ENABLED,
            'created_by'            =>  $user->id,
            'name'                  =>  $data['data']['community_name'],
            'schedule_timing_id'    =>  $data['data']['schedule_timing'],
            'delivery_price'        =>  number_format($data['data']['community_delivery_price'],2)
        );

        if(!Community::create($input))
            return response()->json(['message' => 'Failed to add brgy.'], 422);
        else
            $locations = Location::active()->get();

            return $this->sendResponse($this->retrieveActiveLocationList(), 'Location created successfully.');
    }

    /**
     * Update a created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {        
        $data = $request->json()->all();

        $validator = Validator::make($data, [
            'data' => 'required',
            'login_token' => 'required',
        ]);

        $user = $this->getUserByLoginToken($data['login_token']);

        $data = $data['data'];

        $input = array(
            'name'              =>  $data['name'],
            'delivery_price'    =>  $data['delivery_price'],
            'schedule_timing_id'=>  $data['schedule_timing_id'],
            'updated_by'        =>  $user->id
        );

        if(!Community::where('id', $data['id'])->update($input))
            return response()->json(['message' => 'Failed to update'], 422);
        else
            return $this->sendResponse($this->retrieveActiveLocationList(), 'Community updated successfully.');
    }

    

}