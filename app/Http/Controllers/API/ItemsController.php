<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Services\ItemsService;


class ItemsController extends BaseController
{    

    /**
     * @var $itemsService
     */
    protected $itemsService;

    /**
     * ItemsService constructor
     * 
     * @param ItemsService $itemsService
     */
    public function __construct(ItemsService $itemsService)
    {
        $this->itemsService = $itemsService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $data = $request->json()->all();

        try {
            $result = $this->itemsService->createItem($data);
        } catch (Exception $e){
            return response()->json(['message' => 'Failed to add merchant.'], 422);
        }
        return $this->sendResponse($result, 'Item created successfully.');

    }

    /**
     * Used in admin edit item, to load data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {        

        try {
            $result = $this->itemsService->getItemData($id);
        } catch (Exception $e){
            return response()->json(['message' => 'Failed to add merchant.'], 422);
        }
        return $this->sendResponse($result, 'Item created successfully.');

    }

    /**
     * Update item data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {        
        $data = $request->json()->all();

        try {
            $result = $this->itemsService->updateItem($data);
        } catch (Exception $e){
            return response()->json(['message' => 'Failed to add merchant.'], 422);
        }
        return $this->sendResponse($result, 'Item created successfully.');

    }
}