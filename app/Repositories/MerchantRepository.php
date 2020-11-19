<?php

namespace App\Repositories;

use App\Merchant;

class MerchantRepository
{
    /**
     * @var Merchant
     */
    protected $merchant;

    /**
     * MerchantRepository constructor.
     * 
     * @param Merchant $merchant
     */

     public function __construct(Merchant $merchant)
     {
        $this->merchant = $merchant;
     }
     /**
      * @param $data
      * @return Merchant
      */
    public function save($data)
    {
    $merchant = new $this->merchant;

    $merchant->create($data);

    return $merchant->fresh();
    }
}