<?php

namespace App\Repositories;

use App\Category;

class CategoryRepository
{
    /**
     * @var Category
     */
    protected $category;

    /**
     * MerchantRepository constructor.
     * 
     * @param Category $category
     */

    public function __construct(Category $category)
    {
        $this->category = $category;
    }


     /**
      * @param $data
      * @return Category
      */
    public function save($data)
    {
        $category = new $this->category;

        $category->create($data);

        return $category->fresh();
    }

     /**
      * Table Columns
      */

    public function columns()
    {
        return [
            [
                'label'   => '#',
                'field'   => 'sn',
                'sort'    => 'asc'
            ],
            [
                'label'   => 'Name',
                'field'   => 'name',
                'sort'    => 'asc'
            ],
            [
                'label'   => 'Created by',
                'field'   => 'created_by',
                'sort'    => 'asc'
            ],
            [
                'label'   => 'Updated by',
                'field'   => 'updated_by',
                'sort'    => 'asc'
            ],
            [
                'label'   => 'Status',
                'field'   => 'status',
                'sort'    => 'asc'
            ],
            [
                'label'   => 'View',
                'field'   => 'view',
                'sort'    => 'asc'
            ],
        ];
    }

   /**
    * Validate a Category name passed as request param
    *@param $categoryName
    * @return Category
    */
    public function validateCategoryId($categoryId){
        $result = $this->category->where('id', $categoryId)->first();

        if(!$result){
            return false;
        }

        return $result;
    }

    /**
    * Validate a Category name passed as request param
    *@param $data
    * @return Category
    */
    public function update($id, $data){
        $category = new $this->category;

        $category->where('id', $id)->update($data);

        return $category;
    }
}