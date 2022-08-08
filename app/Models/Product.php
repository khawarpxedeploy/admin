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
        'category',
        'gold_weight',
        'fonts_enabled',
        'symbols_enabled',
        'questions',
        'filters'
    ];

    public function getImageAttribute($value)
    {
        if($value){
           $value = config('app.url').Storage::url($value);
        }
        return $value;
    }

    public function pcategory()
    {
        return $this->belongsTo(Category::class, 'category');
    }

    public function addons()
    {
        return $this->hasMany(ProductAddon::class);
    }
}
