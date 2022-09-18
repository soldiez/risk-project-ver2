<?php

namespace App\Models\Risk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskSeverity extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'risk_method_id',
        'name',
        'sort',
        'value',
        'info',
    ];

    protected $allowedSorts = [
        'id',
        'risk_method_id',
        'name',
        'sort',
        'value',
        'info',
    ];

    protected $allowedFilters = [
        'id',
        'risk_method_id',
        'name',
        'sort',
        'value',
        'info',
    ];

    protected $table = 'risk_severities';

    public function riskMethod(){
        return $this->belongsTo(RiskMethod::class);
    }
    public function risks(){
        return $this->hasMany(Risk::class);
    }

    public function riskZones(){
        return $this->hasMany(RiskZone::class);
    }

}
