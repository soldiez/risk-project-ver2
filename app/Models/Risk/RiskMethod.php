<?php

namespace App\Models\Risk;

use App\Models\Unit\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'category',
        'status',
        'info',
        'is_risk_frequency',
        'is_risk_calculated',
        'parameters',
    ];

    protected $allowedSorts = [
        'id',
        'name',
        'category',
        'status',
        'info',
        'is_risk_frequency',
        'is_risk_calculated',
        'parameters',
    ];

    protected $allowedFilters = [
        'id',
        'name',
        'category',
        'status',
        'info',
        'is_risk_frequency',
        'is_risk_calculated',
        'parameters',
    ];

    protected $table = 'risk_methods';

    public function riskSeverities(){
        return $this->hasMany(RiskSeverity::class);
    }
    public function riskProbabilities(){
        return $this->hasMany(RiskProbability::class);
    }
    public function riskFrequencies(){
        return $this->hasMany(RiskFrequency::class);
    }
    public function riskZones(){
        return $this->hasMany(RiskZone::class);
    }

    public function units(){
        return $this->belongsToMany(Unit::class, 'risk_method_unit');
    }



    public static function boot() {
        parent::boot();

        static::deleting(function($riskMethod) { // before delete() method call this
            $riskMethod->riskSeverities()->delete();
            $riskMethod->riskProbabilities()->delete();
            $riskMethod->riskFrequencies()->delete();
            $riskMethod->riskZones()->delete();
        });
    }
}
