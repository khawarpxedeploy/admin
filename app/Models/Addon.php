<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    use HasFactory;

    const SIZE = 'size';
    const STONE = 'stone';
    const WEIGHT = 'weight';
    const ENGRAVING = 'engraving';

    protected $fillable = [
        'type',
        'title',
        'price',
        'status'
    ];
}
