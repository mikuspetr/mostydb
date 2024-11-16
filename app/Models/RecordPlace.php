<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordPlace extends Model
{
    use HasFactory;
    public $timestamps = false;

    const VSETIN = 1;
    const VALMEZ = 2;
    const OTHER = 3;
    const ALL_PLACES = [self::VSETIN, self::VALMEZ, self::OTHER];
}
