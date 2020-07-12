<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class MerchantCategory extends Model
{
    protected $table = 'merchant_categories';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'merchant_id',
        'category_name',
        'updated_by',
        'status',
    ];
    
}