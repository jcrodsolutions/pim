<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Store extends Model {

//    use HasFactory;

    protected $fillable = ['group_id','store_code','name','location','is_active'];
    protected $casts = [
        'store_code' => 'string',
        'is_active' => 'boolean'
    ];
    
    public function group(): BelongsTo {
        return $this->belongsTo(StoresGroup::class, 'group_id');
    }
}
