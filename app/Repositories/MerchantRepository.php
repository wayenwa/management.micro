<?php

namespace App\Repositories;

use App\Merchant;
use App\Category;
use App\Item;

class MerchantRepository
{
    /**
     * @var Merchant
     * @var Category
     */
    protected $merchant;
    protected $category;

    /**
     * MerchantRepository constructor.
     * 
     * @param Merchant $merchant
     */

    public function __construct(Merchant $merchant, Category $category)
    {
        $this->merchant = $merchant;
        $this->category = $category;
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

    /**
     * Get Merchant details
     * 
     * @param $adminUrl
     * @return Merchant
     */
    public function getByAdminUrl($adminUrl)
    {
        $this->merchant = Merchant::api()->where('admin_url', $adminUrl)->first();

        return $this->merchant;
    }

    /**
     * Get Merchant id
     * 
     * @param $adminUrl
     * @return Merchant
     */
    public function getIdByAdminUrl($adminUrl)
    {
        $this->merchant = Merchant::select('id')->where('admin_url', $adminUrl)->first();

        if(!$this->merchant){
            return false;
        }

        return $this->merchant->id;
    }

     /**
     * Get Merchant name
     * 
     * @param $adminUrl
     * @return Merchant
     */
    public function getNameByAdminUrl($adminUrl)
    {
        $this->merchant = Merchant::select('name')->where('admin_url', $adminUrl)->first();

        return $this->merchant->name;
    }

    /**
     * Get Merchant categories
     */
    public function getMerchantCategories($merchantId, $hideAdminColumns = false)
    {   
        $this->category = ($hideAdminColumns === false) ? Category::where('merchant_id', $merchantId)->active()->tableColumns()->get() : Category::where('merchant_id', $merchantId)->active()->api()->get();
        $this->category = $this->category->toArray();

        foreach($this->category as $key => $value){
            $this->category[$key] = array_merge(
                ['sn' => $key + 1],
                $value
            );
        }

        return $this->category;
    }

    /**
     * PUBLIC URL
     * TO display active merchants
     */
    public function activeList()
    {
        return Merchant::select('name', 'address','admin_url')->active()->get();
    }

    public function getOnsaleList($merchantId)
    {
        $result = Category::select('name','id')->where('merchant_id', $merchantId)->active()->get();

        foreach($result as $key => $category){
            $result[$key]['items'] = Item::where('cat_id', $category['id'])->onSale()->active()->api()->get();
        }

        return $result;
    }

    public function getPopular()
    {
        return [];
    }
}