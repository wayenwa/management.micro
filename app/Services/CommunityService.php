<?php

namespace App\Services;

use App\Repositories\CommunityRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\AuthsTrait;
use InvalidArgumentException;
use Exception;

class CommunityService 
{
    use AuthsTrait;

    /**
     * @var $communityRepository
     */
    protected $communityRepository;

    /**
     * CommunityService constructor
     * 
     * @param CommunityRepository $communityRepository
     */
    public function __construct(CommunityRepository $communityRepository)
    {
        $this->communityRepository = $communityRepository;
    }

    public function retrieveActiveLocationList()
    {   
        $category = $this->communityRepository->retrieveActiveLocationList();

        return $category;
    }

    public function createCommunity($data)
    {
        $validator = Validator::make($data, [
            'data'                => 'required',
            'location_id'         => 'required|integer',
            'login_token'         => 'required',
        ]);

        if($validator->fails()){
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $user = $this->getUserByLoginToken($data['login_token']);

        if(!$user){
            return response()->json(['message' => 'Access expired.'], 401);
        }

        $input = array(
            'location_id'           =>  $data['location_id'],
            'status'                =>  STATUS_ENABLED,
            'created_by'            =>  $user->id,
            'name'                  =>  $data['data']['community_name'],
            'schedule_timing_id'    =>  $data['data']['schedule_timing'],
            'delivery_price'        =>  number_format($data['data']['community_delivery_price'],2)
        );
        return $this->communityRepository->save($input);
    }

    public function updateCommunity($data)
    {        
        $validator = Validator::make($data, [
            'data' => 'required',
            'login_token' => 'required',
        ]);

        $user = $this->getUserByLoginToken($data['login_token']);
        
        if(!$user || $user->user_type != USER_TYPE_SUPER_ADMIN){
            return response()->json(['message' => 'Access expired.'], 401);
        }

        $data = $data['data'];

        $input = array(
            'name'              =>  $data['name'],
            'delivery_price'    =>  $data['delivery_price'],
            'schedule_timing_id'=>  $data['schedule_timing_id'],
            'updated_by'        =>  $user->id
        );

        if($this->communityRepository->update($data['id'], $input))
            return response()->json(['message' => 'Failed to update'], 422);
        else
            return $this->sendResponse($this->retrieveActiveLocationList(), 'Community updated successfully.');
    }
}