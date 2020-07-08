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
        'updated_by'
    ];

   //  public function scopeActive($query)
   //  {
   //      return $query->where('status', 1);
   //  }

   //  public function communities()
   // {
   //     return $this->hasMany('App\Community');
   // }
    
}