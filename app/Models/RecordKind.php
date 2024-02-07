<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordKind extends Model
{
    use HasFactory;
    public $timestamps = false;

    const INDIVIDUAL_ID = 1;
    const GROUP_ID = 2;
    const CONTACT_ID = 4;
}
