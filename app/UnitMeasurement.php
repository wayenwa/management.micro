<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class UnitMeasurement extends Model
{
    protected $table = 'unit_measurements';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'unit', 'created_by', 'type' ];

    // public function scopeApi($query)
    // {           
    //     return $query->select('id', 'unit');
    // }
}
