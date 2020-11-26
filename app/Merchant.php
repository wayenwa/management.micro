<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class Merchant extends Model
{
    protected $table = 'merchants';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address',
        'name',
        'contact_no',
        'created_by',
        'updated_by',
        'status',
        'admin_url'
    ];

    // protected $hidden = array('id', 'created_by','updated_by','created_at','updated_at');
    
    public function scopeApi($query)
    {
        return $query->select('name','address','contact_no');
    }
}