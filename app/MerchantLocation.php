<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class MerchantLocation extends Model
{
    protected $table = 'merchant_locations';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'merchant_id',
        'location_id',
        'updated_by',
        'status',
    ];
    
}