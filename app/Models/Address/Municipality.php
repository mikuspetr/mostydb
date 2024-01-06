<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    const VSETIN_ID = 5878;
    const VALMEZ_ID = 5485;

    public function orp()
    {
        return $this->belongsTo(\App\Models\Address\OrpRegion::class, 'orp_region_id');
    }
}
