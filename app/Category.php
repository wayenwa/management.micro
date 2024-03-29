<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'merchant_id',
        'status',
        'created_by',
        'cat_id',
        'updated_by'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', STATUS_ENABLED);
    }

    /**
     * NOTE:  Used in Category table. Arrangement of columns are vital!!!
     */
    public function scopeTableColumns($query)
    {   
        $query->leftJoin('users', 'categories.created_by', '=', 'users.id');
        
        return $query->select('categories.name','users.name as created_by','categories.updated_by','categories.status', 'categories.id');
    }

    public function scopeApi($query)
    {   
        $query->leftJoin('users', 'categories.created_by', '=', 'users.id');
        
        return $query->select('categories.name','categories.status', 'categories.id as category_id');
    }
    
}