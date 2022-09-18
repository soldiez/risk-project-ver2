<?php

namespace App\Models\Risk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskZone extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'risk_method_id',
        'name',
        'value',
        'colour',
        'info',
        'risk_severity_id',
        'risk_probability_id'
    ];

    protected $allowedSorts = [
        'id',
        'risk_method_id',
        'name',
        'value',
        'colour',
        'info',
        'risk_severity_id',
        'risk_probability_id'
    ];

    protected $allowedFilters = [
        'id',
        'risk_method_id',
        'name',
        'value',
        'colour',
        'info',
        'risk_severity_id',
        'risk_probability_id'
    ];

    protected $table = 'risk_zones';

    public function riskMethod(){
        return $this->belongsTo(RiskMethod::class);
    }

    public function riskSeverity(){
        return $this->belongsTo(RiskSeverity::class);
    }

    public function riskProbability(){
        return $this->belongsTo(RiskProbability::class);
    }

    public function riskFrequency(){
        return $this->belongsTo(RiskFrequency::class);
    }

    public function risks(){
        return $this->hasMany(Risk::class);
    }

}


