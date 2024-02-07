<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordColor extends Model
{
    const GREEN = 1;
    const BLUE = 2;
    const RED = 3;

    use HasFactory;
    public $timestamps = false;
}
