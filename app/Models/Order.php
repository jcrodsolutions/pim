<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model {

    use HasFactory,
        SoftDeletes;

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }
    
    //use Illuminate\Database\Eloquent\Relations\HasMany;
    public function items(): HasMany {
        return $this->hasMany(OrderItem::class);
    }
}
