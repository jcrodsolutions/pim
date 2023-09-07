<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo,
    HasMany,
};

class Order extends Model {

    use HasFactory,
        SoftDeletes;
    protected $fillable = ['customer_id','order','status','shipping_price','notes'];

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany {
        return $this->hasMany(OrderItem::class);
    }
}
