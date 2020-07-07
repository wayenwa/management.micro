<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class Community extends Model
{
    protected $table = 'communities';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'location_id',
        'name',
        'delivery_price',
        'created_by',
        'updated_by',
        'status'
    ];

    public function location()
   {
       return $this->belongsTo('App\Location');
   }
    
}