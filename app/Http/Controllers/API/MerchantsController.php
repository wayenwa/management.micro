<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Services\MerchantService;

class MerchantsController extends BaseController
{
    /**
     * @var $merchantService
     */
    protected $merchantService;

    /**
     * MerchantService constructor
     * 
     * @param MerchantService $merchantService
     */
    public function __construct(MerchantService $merchantService)
    {
        $this->merchantService = $merchantService;
    }

    public function index()
    {
        $merchants = $this->merchantService->retrieveActiveMerchantList();
        
        return $this->sendResponse($merchants, 'Merchants retrieved successfully.');
    }

    public function store(Request $request, MerchantService $merchantService)
    {
        $data = $request->json()->all();

        try {
            $result = $this->merchantService->createMerchant($data);
        } catch (Exception $e){
            return response()->json(['message' => 'Failed to add merchant.'], 422);
        }
        return $this->sendResponse($result, 'Merchant created successfully.');
    }

    public function show($id)
    {
        /**
         * Validate passed Admin url, else continue.
         */
        $merchantId = $this->merchantService->validateAdminUrl($id);

        if( !$merchantId ){
            return response()->json(['message' => 'Merchant not found.'], 404);
        }

        $redis  = Redis::connection();
        $key    = REDIS_PREFIX_MERCHANT.':'.REDIS_PREFIX_ADMIN.':'.$id.':'.REDIS_MERCHANT_CATEGORY_FILE;

        /**
         * If Redis key exists, show data from redis.
         * Else, get from Mysql then save to redis.
         */
        
        if($redis->exists($key)){
            $result = json_decode($redis->get($key));
        }else{
            $result = [
                'merchant'          =>  $this->merchantService->getMerchantNameByAdminUrl($id),
                'categories'        =>  [
                    'cols'  =>  $this->merchantService->categoryColumns(),
                    'rows'  =>  $this->merchantService->merchantCategories($merchantId)
                ],
                'onSale'            =>  $this->merchantService->onSale($merchantId),
                'popular'           =>  $this->merchantService->popular($merchantId),
            ];

            $redis->set($key, json_encode($result));
            $redis->expire($key, (env('REDIS_EXPIRY_MINUTES') * 60));
        }
        

        return $this->sendResponse($result, 'Merchant data retrieved.');
    }

}