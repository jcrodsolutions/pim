<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StoresGroup extends Model {

    protected $table = 'stores_group';
    protected $fillable = ['group_code', 'group'];
    protected $casts = [
        'group_code' => 'string'
    ];

    public function stores(): HasMany {
        return $this->hasMany(Store::class, 'group_id');
    }
}
