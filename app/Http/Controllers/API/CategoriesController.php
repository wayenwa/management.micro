<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Services\CategoryService;

class CategoriesController extends BaseController
{

    /**
     * @var $categoryService
     */
    protected $categoryService;

    /**
     * @var $categoryService
     */
    protected $merchantService;

    /**
     * CommunityService constructor
     * 
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {   
    //     $locations = $this->communityService->retrieveActiveLocationList();

    //     return $this->sendResponse($locations, 'Community retrieved successfully.');
    // }


    public function store(Request $request)
    {
        $data = $request->json()->all();

        try {
            $result = $this->categoryService->createCategory($data);
        } catch (Exception $e){
            return response()->json(['message' => 'Failed to add Barangay.'], 422);
        }
        return $this->sendResponse([], 'Category created successfully.');
    }

    public function category(Request $request)
    {
        $data = $request->json()->all();

        try {
            $result = $this->categoryService->categoryData($data);

            if($result === false){
                return response()->json(['message' => 'Invalid request.'], 404);
            }
        } catch (Exception $e){
            return response()->json(['message' => 'Invalid request.'], 404);
        }

        return $this->sendResponse($result, '');
    }
    
    /**
     * Update a created resource in storage.
     *
     */
    public function update(Request $request)
    {        
        $data = $request->json()->all();

        try {
            $result = $this->categoryService->updateCategory($data);
        } catch (Exception $e){
            return response()->json(['message' => 'Failed to update Category.'], 422);
        }
        return $this->sendResponse($data['text'], 'Category updated successfully.');
    }

    

}