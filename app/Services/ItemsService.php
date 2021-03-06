<?php

namespace App\Services;

use App\Http\Traits\AuthsTrait;
use App\Repositories\ItemsRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\CommonTraits;
use App\Repositories\UnitMeasureRepository;

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
     /**
     * @var $unitMeasureRepository
     */
    protected $unitMeasureRepository;

    public function __construct( ItemsRepository $itemsRepository, UnitMeasureRepository $unitMeasureRepository )
    {
        $this->itemsRepository = $itemsRepository;
        $this->unitMeasureRepository = $unitMeasureRepository;
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
            'status'            => 'required',
            'cat_id'            => 'required',
        ]);


        if($validator->fails()){
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        $user = $this->getUserByLoginToken($data['login_token']);

        if(!$user){
            return response()->json(['message' => 'Access expired.'], 422);
        }
        

        $input = array(
            'name'              =>  $data['item_name'],
            'merchant_price'    =>  $data['merchant_price'],
            'selling_price'     =>  $data['selling_price'],
            'promo_price'       =>  $data['promo_price'],
            'desc'              =>  $data['desc'],
            'unit'              =>  $data['unit']['unit'],
            'unit_type'         =>  $data['unit']['type'],
            'measurement'       =>  $data['measurement'],
            'status'            =>  $data['status'],
            'cat_id'            =>  $data['cat_id']
        );

        return $this->itemsRepository->save($input);
    }

    public function getItemData($id)
    {
        $details = $this->itemsRepository->getDetails($id);

        return [
            'unit_measure'  =>  $this->unitMeasureRepository->retrieveAll(),
            'details'       =>  $details,
        ];
    }

    public function updateItem($data)
    {
        $validator = Validator::make($data, [
            'item_name'     => 'required',
            'login_token'   => 'required',
            'selling_price' => 'required',
        ]);

        $user = $this->getUserByLoginToken($data['login_token']);
        
        if(!$user || $user->user_type == USER_TYPE_CUSTOMER){
            return response()->json(['message' => 'Access expired.'], 401);
        }

        $input = [
            'name'                  => $data['item_name'],
            'desc'                  => $data['desc'],
            'measurement'           => $data['measurement'],
            'merchant_price'        => $data['merchant_price'],
            'selling_price'         => $data['selling_price'],
            'promo_price'           => $data['promo_price'],
            'status'                => $data['status'],
            'unit'                  => $this->unitMeasureRepository->getNameByUnitId($data['unit']),
            'unit_type'             => $this->unitMeasureRepository->getTypeByUnitId($data['unit']),
            'is_popular'            => $data['popular']
        ];

        if( $this->itemsRepository->update($input, $data['id']) != null ){
            return response()->json(['message' => 'Precondition Failed.'], 412);
        }

        return $this->getItemData($data['id']);
    }
}