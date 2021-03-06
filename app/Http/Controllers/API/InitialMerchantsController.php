<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Services\MerchantService;
use App\Merchant;
use App\Location;
use Illuminate\Support\Facades\Redis;

class InitialMerchantsController extends BaseController
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataReference()
    {   
        $locations = Location::select('id','location')->active()->orderBy('location', 'asc')->get();
        foreach ($locations as $key => $value) {
           $locations[$key]['isSelected'] = false; 
        }
        $data = [
            'locations' =>  $locations
        ];

        return $this->sendResponse($data, 'Merchants data retrieved successfully.');
    }

    /**
     * Used in "shop/:merchant" page
     * to load all neccessary data needed
     *
     * @return \Illuminate\Http\Response
     */

    public function merchants_data($merchantName)
    {
        $merchantId = $this->merchantService->validateAdminUrl($merchantName);

        if( !$merchantId ){
            return response()->json(['message' => 'Merchant not found.'], 404);
        }

        /**
         * If Redis key exists, show data from redis.
         * Else, get from Mysql then save to redis.
         */

        $redis  = Redis::connection();
        $key    = REDIS_PREFIX_MERCHANT.':'.REDIS_PREFIX_MERCHANT.':'.$merchantName.':'.REDIS_MERCHANT_INDEX;
        
        if($redis->exists($key)){
            $result = json_decode($redis->get($key));
        }else{
            $result = [
                'details'           =>  $this->merchantService->getShopData($merchantName),
                'categories'        =>  $this->merchantService->merchantCategories($merchantId, true),
                'merchants'         =>  $this->merchantService->retrieveActiveMerchantList(),
                'initial_product'   =>  $this->merchantService->initial_product($merchantId, QUICKLINKS_POPULAR)
            ];

            $redis->set($key, json_encode($result));
            $redis->expire($key, (env('REDIS_EXPIRY_MINUTES') * 60));
        }

        

        return $this->sendResponse($result, 'Merchants data retrieved successfully.');
    }

}