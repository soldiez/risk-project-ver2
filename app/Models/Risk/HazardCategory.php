<?php

namespace App\Models\Risk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HazardCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'type',
        'name',
    ];

    protected $allowedSorts = [
        'id',
        'type',
        'name',
    ];

    protected $allowedFilters = [
        'id',
        'type',
        'name',
    ];

    protected $table = 'hazard_categories';

}
