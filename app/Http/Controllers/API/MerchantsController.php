<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Traits\AuthsTrait;
use App\Merchant;

class MerchantsController extends BaseController
{

    use AuthsTrait;

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
            'name'            => 'required',
            'address'         => 'required',
            'contact_no'      => 'required',
            'login_token'     => 'required',
            'permission'      => 'required'
        ]);

        $user = $this->getUserByLoginToken($data['login_token']);

        if(!$this->checkPermission($data['permission'])){
            return response()->json(['message' => 'Permission not valid.'], 422);
        }

        $input = array(
            'name'           =>  $data['name'],
            'address'        =>  $data['address'],
            'contact_no'     =>  $data['contact_no'],
            'created_by'     =>  $user->id,
            'status'         =>  STATUS_ENABLED
        );

        if(!Merchant::create($input))
            return response()->json(['message' => 'Failed to add merchant.'], 422);
        else
            return $this->sendResponse([], 'Merchant created successfully.');
    }
    

}