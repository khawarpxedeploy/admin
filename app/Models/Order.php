<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_id',
        'type',
        'status',
        'total',
        'pickup_location',
        'delivery_location',
        'payment_method',
        'payment_status',
        'cancelled_reason',
        'delivered_on',
        'cancelled_reason'
    ];

    protected $hidden = [
        'customer_id',
        'updated_at',
    ];

    public function getDeliveryLocationAttribute($value)
    {
        return json_decode($value);
    }

        public function customer()
        {
            return $this->belongsTo(Customer::class);
        }

        public function items()
        {
            return $this->hasMany(OrderItems::class);
        }
    }
