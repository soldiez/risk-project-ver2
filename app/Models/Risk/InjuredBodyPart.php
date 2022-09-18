<?php

namespace App\Models\Risk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InjuredBodyPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'code',
        'name',
    ];

    protected $allowedSorts = [
        'id',
        'code',
        'name',
    ];

    protected $allowedFilters = [
        'id',
        'code',
        'name',
    ];

    protected $table = 'injured_body_parts';
}
