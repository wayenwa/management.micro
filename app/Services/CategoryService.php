<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Repositories\MerchantRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\AuthsTrait;
use InvalidArgumentException;
use Exception;

class CategoryService 
{
    use AuthsTrait;

    /**
     * @var $categoryRepository
     */
    protected $categoryRepository;

     /**
     * @var $merchantRepository
     */
    protected $merchantRepository;

    /**
     * CommunityService constructor
     * 
     * @param CategoryRepository $categoryRepository
     * @param MerchantRepository $merchantsRepository
     */
    public function __construct(CategoryRepository $categoryRepository, MerchantRepository $merchantRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->merchantRepository = $merchantRepository;
    }

    public function createCategory($data)
    {
        $validator = Validator::make($data, [
            'name'                => 'required',
            'login_token'         => 'required',
            'permission'          => 'required',
            'merchant'            => 'required',
        ]);

        if($validator->fails()){
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $user = $this->getUserByLoginToken($data['login_token']);

        if(!$user || $user->user_type == USER_TYPE_CUSTOMER){
            return response()->json(['message' => 'Access expired.'], 401);
        }

        $input = array(
            'name'                  =>  $data['name'],
            'status'                =>  STATUS_ENABLED,
            'merchant_id'           =>  $this->merchantRepository->getIdByAdminUrl($data['merchant']),
            'created_by'            =>  $user->id
        );

        return $this->categoryRepository->save($input);
    }

    public function categoryData($data)
    {
        $validator = Validator::make($data, [
            'merchant'         => 'required',
            'category'         => 'required'
        ]);

        if($validator->fails()){
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $category = $this->categoryRepository->validateCategoryId($data['category']);

        if(!$category){
            return false;
        }

        return [
            'merchant_name'     =>  $this->merchantRepository->getNameByAdminUrl($data['merchant']),
            'merchant_id'       =>  $this->merchantRepository->getIdByAdminUrl($data['merchant']),
            'admin_url'         =>  $data['merchant'],
            'category'          =>  $category->name,
            'cat_id'            =>  $category->id,
        ];


    }

    public function updateCategory($data)
    {        
        $validator = Validator::make($data, [
            'text'          => 'required',
            'login_token'   => 'required',
            'merchant_id'   => 'required',
            'cat_id'        => 'required',
        ]);

        $user = $this->getUserByLoginToken($data['login_token']);
        
        if(!$user || $user->user_type == USER_TYPE_CUSTOMER){
            return response()->json(['message' => 'Access expired.'], 401);
        }

        $input = [
            'name' => $data['text']
        ];

        $result = $this->categoryRepository->update($data['cat_id'], $input);

        return $result;
    }

    
}