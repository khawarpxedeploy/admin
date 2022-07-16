<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_id',
        'order_id',
        'type',
        'status',
        'price',
        'pickup_location',
        'delivery_location',
        'addons',
        'questions',
        'symbols',
        'fonts',
        'payment_method',
        'payment_status',
        'cancelled_reason',
        'delivered_on',
        'cancelled_reason'
    ];

    public function getDeliveryLocationAttribute($value)
    {
        return json_decode($value);
    }

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

        public function customer()
        {
            return $this->belongsTo(Customer::class);
        }

        public function product()
        {
            return $this->belongsTo(Product::class);
        }
    }
