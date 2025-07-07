<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasDate;

class IndividualPlan extends Model
{
    use HasFactory;
    use HasDate;

    protected $fillable = [
        'client_id',
        'date',
        'title',
        'text',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
