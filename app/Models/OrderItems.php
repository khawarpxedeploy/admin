<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;


    protected $fillable = [
        'product_id',
        'order_id',
        'addons',
        'questions',
        'symbols',
        'fonts',
        'sub_total'
    ];

    protected $hidden = [
        'id',
        'updated_at'
    ];

    public function getQuestionsAttribute($value)
    {
        if($value){
            $value = json_decode($value);
            foreach($value as $question){
                $check = Question::where('id', $question->id)->select('question')->first();
                if($check){
                    $question->id = $check->question; 
                }
            }
            return $value;
        }
        else{
            return $value;
        }
    }

    public function getAddonsAttribute($value)
    {
        if($value){
            $temp = array();
            $value = json_decode($value);
            foreach($value as $addon){
                $check = Addon::where('id', $addon)->select('type', 'title', 'price')->first();
                if($check){
                    $temp[] = $check;
                }
            }
            return $temp;
        }
        else{
            return $value;
        }
        
    }
}
