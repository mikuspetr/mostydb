<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordForm extends Model
{
    use HasFactory;
    public $timestamps = false;

    const PERSONAL = 1;
    const PHONE = 2;
    const TEXT = 3;
}
