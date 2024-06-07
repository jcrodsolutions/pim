<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Description of Sku: Stock Keeping Unit
 *
 */
class Sku extends Model {

    protected $fillable = ['sku', 'material', 'um'];
    protected $casts = [
        'material' => 'string',
    ];

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class, 'material', 'material');
    }
}
