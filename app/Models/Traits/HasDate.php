<?php

namespace App\Models\Traits;

use \Carbon\Carbon;

trait HasDate
{
    public function getDatumAttribute()
    {
        return Carbon::parse($this->date)->format('j. n. Y');
    }
}