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
     * UnitMeasurement constructor.
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

     /**
     * used in admin's edit item data load.
     * 
     * @param UnitMeasurement $unitMeasurement
     */
    public function getIdByUnit($unit)
    {
        $model = new $this->unitMeasurement;
        
        $result = $model->select('id')->where('unit', $unit)->first();

        return $result;
    }

    /**
     * get type by unit.
     * 
     * @param UnitMeasurement $unitMeasurement
     */
    public function getTypeByUnitId($id)
    {
        $model = new $this->unitMeasurement;
        
        $result = $model->select('type')->where('id', $id)->first();

        return $result->type;
    }

    /**
     * get unit name by unit id.
     * 
     * @param UnitMeasurement $unitMeasurement
     */
    public function getNameByUnitId($id)
    {
        $model = new $this->unitMeasurement;
        
        $result = $model->select('unit')->where('id', $id)->first();

        return $result->unit;
    }

}