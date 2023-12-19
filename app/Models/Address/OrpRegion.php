<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Model;

class OrpRegion extends Model
{
    const VALMEZ_ORP_ID = 7210;
    const VSETIN_ORP_ID = 7212;
    const ACTIVE_ORP_IDS = [7206, 7210, 7211, 7212];

    public $timestamps = false;

    public function municipalities()
    {
        return $this->hasMany(\App\Models\Address\Municipality::class);
    }
}
