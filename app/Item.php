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
        'cat_id',
        'promo_price',
        'is_popular'
    ];

    
    public function scopeApi($query)
    {   
        return $query->select(
            'id',
            'name as item_name',
            'desc as description',
            'image',
            'measurement',
            'unit',
            'unit_type',
            'merchant_price',
            'selling_price',
            'promo_price',
            'status',
            'is_popular'
        );
    }

    public function scopeActive($query)
    {
        return $query->where('status', STATUS_ENABLED);
    }

    public function scopeOnSale($query)
    {
        return $query->where('promo_price', '>', 0.00);
    }
}