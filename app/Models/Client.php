<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    const MALE_ID = 1;
    const FEMALE_ID = 2;
    const ADDICTED_ID = 1;
    const NEUROTIC_ID = 2;

    const NEW_ADICTED_ID = 501;
    const NEW_NEUROTIC_ID = 502;

    public function type()
    {
        return $this->belongsTo(\App\Models\ClientType::class);
    }
    public function sex()
    {
        return $this->belongsTo(\App\Models\Sex::class);
    }

    public function getClientCodeAttribute()
    {
        return 'SNP-' . $this->code . mb_substr($this->sex->name, 0,1) . '-' . $this->pair_id . '-' . mb_substr($this->type->name, 0,1);
    }

    public function description()
    {
        return $this->hasOne(\App\Models\ClientDescription::class)->withDefault();
    }

    public static function getNextPairId()
    {
        $lastClient = \App\Models\Client::where('pair_id', '!=', 'ZAJ')->orderByDesc('pair_id')->first();
        return $lastClient->pair_id + 1;
    }
}
