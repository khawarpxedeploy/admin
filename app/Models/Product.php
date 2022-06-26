<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
        'fonts_enabled',
        'symbols_enabled',
        'questions'
    ];

    public function getImageAttribute($value)
    {
        if($value){
           $value = Storage::url($value);
        }
        return $value;
    }
}
