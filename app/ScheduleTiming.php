<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class ScheduleTiming extends Model
{   
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mon',
        'tue',
        'wed',
        'thu',
        'fri',
        'sat',
        'sun',
        'from',
        'to',
        'created_by',
        'updated_by',
        'name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_by','updated_by'
    ];

  
    
}