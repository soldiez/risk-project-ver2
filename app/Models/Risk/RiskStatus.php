<?php

namespace App\Models\Risk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name'
    ];

    protected $allowedSorts = [
        'id',
        'name'
    ];

    protected $allowedFilters = [
        'id',
        'name'
    ];

    protected $table = 'risk_statuses';

}
