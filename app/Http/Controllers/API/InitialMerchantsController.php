<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Services\MerchantService;
use App\Merchant;
use App\Location;

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

        $result = [
            'details'       =>  $this->merchantService->getShopData($merchantName),
            'categories'    =>  $this->merchantService->merchantCategories($merchantName, true)
        ];

        return $this->sendResponse($result, 'Merchants data retrieved successfully.');
    }

}