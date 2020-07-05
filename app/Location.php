<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class Location extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'location',
        'status',
        'created_by',
        'updated_by'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
    
}