<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of Um
 * 
 * Units of measure
 *
 */
class Um extends Model {

    protected $fillable = ['um', 'description', 'is_active'];
    protected $casts = [
        'um' => 'string',
        'is_active' => 'boolean',
    ];
}
