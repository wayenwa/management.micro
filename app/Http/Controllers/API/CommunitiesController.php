<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Services\CommunityService;
use App\Community;
use App\Location;

class CommunitiesController extends BaseController
{

    /**
     * @var $merchantService
     */
    protected $communityService;

    /**
     * CommunityService constructor
     * 
     * @param CommunityService $communityService
     */
    public function __construct(CommunityService $communityService)
    {
        $this->communityService = $communityService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $locations = $this->communityService->retrieveActiveLocationList();

        return $this->sendResponse($locations, 'Community retrieved successfully.');
    }


    public function store(Request $request)
    {
        $data = $request->json()->all();

        try {
            $result = $this->communityService->createCommunity($data);
        } catch (Exception $e){
            return response()->json(['message' => 'Failed to add Barangay.'], 422);
        }
        return $this->sendResponse($this->communityService->retrieveActiveLocationList(), 'Barangay created successfully.');
    }

    /**
     * Update a created resource in storage.
     *
     */
    public function update(Request $request)
    {        
        $data = $request->json()->all();

        try {
            $result = $this->communityService->updateCommunity($data);
        } catch (Exception $e){
            return response()->json(['message' => 'Failed to update Barangay.'], 422);
        }
        return $this->sendResponse($this->communityService->retrieveActiveLocationList(), 'Barangay updated successfully.');
    }

    

}