<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'questions',
        'filters'
    ];

    public function getImageAttribute($value)
    {
        if($value){
           $value = Storage::url($value);
        }
        return $value;
    }

    public function addons()
    {
        return $this->hasMany(ProductAddon::class);
    }
}
