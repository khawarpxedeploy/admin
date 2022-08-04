<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'logo',
        'shop_charges'
    ];

    public function getLogoAttribute($value)
    {
        if($value){
           $value = config('app.url').Storage::url($value);
        }
        return $value;
    }
}

