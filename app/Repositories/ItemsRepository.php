<?php

namespace App\Repositories;

use App\Item;

class ItemsRepository
{
    /**
     * @var Item
     */
    protected $item;

    /**
     * MerchantRepository constructor.
     * 
     * @param Item $item
     */

     public function __construct(Item $item)
     {
        $this->item = $item;
     }

     public function save($data)
     {
        $item = new $this->item;

        $item->create($data);

        return $item->fresh();
     }

}