<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class Item extends Model
{
    protected $table = 'items';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'desc',
        'unit',
        'unit_type',
        'measurement',
        'merchant_price',
        'selling_price',
        'image',
        'status',
    ];

    // // protected $hidden = array('id', 'created_by','updated_by','created_at','updated_at');
    
    // public function scopeApi($query)
    // {
    //     return $query->select('name','address','contact_no');
    // }

    // public function scopeActive($query)
    // {
    //     return $query->where('status', STATUS_ENABLED);
    // }
}