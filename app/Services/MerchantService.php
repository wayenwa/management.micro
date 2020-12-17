<?php

namespace App\Services;

use App\Repositories\MerchantRepository;
use App\Repositories\CategoryRepository;
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
     * @var $categoryRepository
     */
    protected $categoryRepository;

    /**
     * MerchantService constructor
     * 
     * @param MerchantRepository $merchantRepository
     */
    public function __construct(MerchantRepository $merchantRepository, CategoryRepository $categoryRepository)
    {
        $this->merchantRepository = $merchantRepository;
        $this->categoryRepository = $categoryRepository;
    }
    public function retrieveActiveMerchantList()
    {
        return $this->merchantRepository->activeList();
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

        if(!$user || $user->user_type != USER_TYPE_SUPER_ADMIN){
            return response()->json(['message' => 'Access expired.'], 422);
        }
        
        $input = array(
            'name'           =>  $data['name'],
            'address'        =>  $data['address'],
            'contact_no'     =>  $data['contact_no'],
            'created_by'     =>  $user->id,
            'status'         =>  STATUS_ENABLED
        );

        return $this->merchantRepository->save($input);
    }

    public function getMerchantIdByAdminUrl($adminUrl)
    {
        return $this->merchantRepository->getIdByAdminUrl($adminUrl);
    }

    public function getMerchantNameByAdminUrl($adminUrl)
    {
        return $this->merchantRepository->getNameByAdminUrl($adminUrl);
    }

    public function merchantCategories($adminUrl, $hideAdminColumns = false)
    {
        $merchantId = $this->merchantRepository->getIdByAdminUrl($adminUrl);

        return $this->merchantRepository->getMerchantCategories($merchantId, $hideAdminColumns);
    }

    public function categoryColumns()
    {
        return $this->categoryRepository->columns();
    }

    public function getShopData($adminUrl)
    {
        return $this->merchantRepository->getByAdminUrl($adminUrl);


    }
}