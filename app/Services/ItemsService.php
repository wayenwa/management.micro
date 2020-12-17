<?php

namespace App\Services;

use App\Http\Traits\AuthsTrait;
use App\Repositories\ItemsRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\CommonTraits;

class ItemsService 
{
    use AuthsTrait;
    use CommonTraits;

    /**
     * @var $itemsRepository
     */
    protected $itemsRepository;

    /**
     * CommunityService constructor
     * 
     * @param ItemsRepository $itemsRepository
     */
    public function __construct(ItemsRepository $itemsRepository)
    {
        $this->itemsRepository = $itemsRepository;
    }

    public function createItem($data)
    {
        $validator = Validator::make($data, [
            'item_name'         => 'required',
            'merchant_price'    => 'required',
            'selling_price'     => 'required',
            'desc'              => 'required',
            'unit'              => 'required',
            'measurement'       => 'required',
            'status'            => 'required'
        ]);


        if($validator->fails()){
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $user = $this->getUserByLoginToken($data['login_token']);

        if(!$user){
            return response()->json(['message' => 'Access expired.'], 422);
        }
        

        $input = array(
            'name'              =>  $data['item_name'],
            'merchant_price'    =>  $data['merchant_price'],
            'selling_price'     =>  $data['selling_price'],
            'desc'              =>  $data['desc'],
            'unit'              =>  $data['unit']['unit'],
            'unit_type'         =>  $data['unit']['type'],
            'measurement'       =>  $data['measurement'],
            'status'            =>  $data['status']
        );

        return $this->itemsRepository->save($input);
    }

}