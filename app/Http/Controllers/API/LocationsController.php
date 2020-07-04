<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\DB;
use App\Location;
use App\Http\Traits\AuthsTrait;

class LocationsController extends BaseController
{
    use AuthsTrait;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $category = Location::all();
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
        
        $input = array(
                'location' => $request->json('municipality'),
                'status' => STATUS_ENABLED,
        );

        $validator = Validator::make($input, [
            'name' => 'required',
            'category_timing_id' => 'required',
            'status'=> 'required',
            'merchant_id' => 'required',
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }


        $category = Category::create($input);


        return $this->sendResponse($category->toArray(), 'Category created successfully.');
    }


}