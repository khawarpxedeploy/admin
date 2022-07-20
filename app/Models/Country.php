<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    public const DEFAULT_COUNTRY = 'Germany';
    public const DEFAULT_CURRENCY = 'EUR';

    protected $fillable = [
        'name',
        'code',
        'currency',
        'currency_symbol'
    ];
}
