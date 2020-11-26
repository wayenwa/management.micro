<?php

namespace App\Http\Controllers\API;

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
        $result = [
            'merchant'      =>  $this->merchantService->getMerchantNameByAdminUrl($id),
            'categories'    =>  [
                'cols' => $this->merchantService->categoryColumns(),
                'rows' => $this->merchantService->merchantCategories($id)
            ]
        ];

        return $this->sendResponse($result, 'Merchant created successfully.');
    }

}