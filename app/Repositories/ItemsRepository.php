<?php

namespace App\Repositories;

use App\Item;
use App\Repositories\UnitMeasureRepository;

class ItemsRepository
{
    /**
     * @var Item
     */
    protected $item;

    /**
     * @var UnitMeasureRepository
     */
    protected $UnitMeasureRepository;

    /**
     * MerchantRepository constructor.
     * 
     * @param Item $item
     * @param UnitMeasureRepository $UnitMeasureRepository
     */

     public function __construct(Item $item, UnitMeasureRepository $UnitMeasureRepository)
     {
        $this->item = $item;
        $this->unitMeasurement = $UnitMeasureRepository;
     }

    public function save($data)
    {
        $item = new $this->item;

        $item->create($data);

        return $item->fresh();
    }

    public function update($data, $id)
    {
        $item = new $this->item;

        if( !$item->where('id', $id)->update($data) )
        {
            return false;
        }

        return $item->fresh();
    }

     /**
     * List of items for Category
     */
    public function categoryItems($catId)
    {
        
        $item = new $this->item;

        return $item->where('cat_id', $catId)->api()->get();

    }

    /**
     * retrieve item details
     */
    public function getDetails($id)
    {
        
        $item = new $this->item;
        $item = $item->where('id',$id)->api()->first();

        $unitId = $this->unitMeasurement->getIdByUnit($item->unit);
        $item->unit_id = $unitId->id;
        return $item;

    }

}