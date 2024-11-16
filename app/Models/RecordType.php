<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordType extends Model
{
    use HasFactory;
    public $timestamps = false;

    const SITUATIONAL = 1;
    const CRISIS = 2;
    const SOCIAL_DIAGNOSTIC = 3;

    const SERVICE_INFORMATIONS = 4;
    const ARRANGED_MEETING = 5;
    const OTHER = 6;
}
