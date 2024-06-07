<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo,
    BelongsToMany,
    HasMany,
};

class Product extends Model {

//    use HasFactory;

    protected $fillable = ['brand_id', 'name', 'slug', 'material',
        'description', 'image', 'is_visible',
        'is_featured', 'type', 'published_at'];
    protected $casts = [
        'material' => 'string',
        'is_visible' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function brand(): BelongsTo {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany {
        return $this->belongsToMany(Category::class);
    }

    public function skus(): HasMany {
        return $this->hasMany(Sku::class, 'material', 'material');
    }
}
