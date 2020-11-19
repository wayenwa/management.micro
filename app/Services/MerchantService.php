<?php

namespace App\Services;

use App\Repositories\MerchantRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\AuthsTrait;
use InvalidArgumentException;
use Exception;

class MerchantService 
{
    use AuthsTrait;

    /**
     * @var $merchantRepository
     */
    protected $merchantRepository;

    /**
     * MerchantService constructor
     * 
     * @param MerchantRepository $merchantRepository
     */
    public function __construct(MerchantRepository $merchantRepository)
    {
        $this->merchantRepository = $merchantRepository;
    }

    public function createMerchant($data)
    {
        $validator = Validator::make($data, [
            'name'            => 'required',
            'address'         => 'required',
            'contact_no'      => 'required',
            'login_token'     => 'required',
            'permission'      => 'required'
        ]);

        if($validator->fails()){
            throw new InvalidArgumentException($validator->errors()->first());
        }

        if(!$this->checkPermission($data['permission'])){
            return response()->json(['message' => 'Permission not valid.'], 422);
        }

        $user = $this->getUserByLoginToken($data['login_token']);

        $input = array(
            'name'           =>  $data['name'],
            'address'        =>  $data['address'],
            'contact_no'     =>  $data['contact_no'],
            'created_by'     =>  $user->id,
            'status'         =>  STATUS_ENABLED
        );

        return $this->merchantRepository->save($input);
    }
}