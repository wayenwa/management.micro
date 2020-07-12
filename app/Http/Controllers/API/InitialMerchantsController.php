<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Merchant;
use App\Location;


class InitialMerchantsController extends BaseController
{
    
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

}