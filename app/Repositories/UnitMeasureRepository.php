<?php

namespace App\Repositories;

use App\UnitMeasurement;

class UnitMeasureRepository
{
    /**
     * @var UnitMeasurement
     */
    protected $unitMeasurement;

    /**
     * MerchantRepository constructor.
     * 
     * @param UnitMeasurement $unitMeasurement
     */

     public function __construct(UnitMeasurement $unitMeasurement)
     {
        $this->unitMeasurement = $unitMeasurement;
     }
     /**
      * @return UnitMeasurement
      */
    public function retrieveAll()
    {
        $model = new $this->unitMeasurement;
        $result = $model->select('id','unit', 'type')->get();
        
        return $result;
    }

}