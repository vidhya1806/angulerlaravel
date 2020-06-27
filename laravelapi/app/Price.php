<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model {
    use SoftDeletes;
    protected $table = 'price';
    protected $guarded = [];
    protected $fillable = [
        'name',
        'code',
        'description',
        'price',
        'isactive',
        'created_date',
        'created_by',
        'updated_date',
        'updated_by',
        'deleted_date',
        'deleted_by'
    ];
    
}