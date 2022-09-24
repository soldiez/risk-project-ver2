<?php

namespace App\Models\Risk;

use App\Models\Action;
use App\Models\Unit\Activity;
use App\Models\Unit\Department;
use App\Models\Unit\Position;
use App\Models\Unit\Process;
use App\Models\Unit\Product;
use App\Models\Unit\Service;
use App\Models\Unit\Territory;
use App\Models\Unit\Unit;
use App\Models\Unit\Worker;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Risk extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'unit_id',
        'hazard_info',
        'hazard_category_id',
        'injured_body_part_id',
        'base_risk_info',
        'base_preventive_action',
        'risk_method_id',
        'base_severity_id',
        'base_probability_id',
        'base_frequency_id',
        'base_calc_risk',
        'prop_preventive_action',
        'prop_severity_id',
        'prop_probability_id',
        'prop_frequency_id',
        'prop_calc_risk',
        'create_date_time',
        'creator_id',
        'review_date',
        'auditor_id',
        'control_review_date',
        'risk_status',
    ];

    protected $allowedSorts = [
        'id',
        'unit_id',
        'hazard_info',
        'hazard_category_id',
        'injured_body_part_id',
        'base_risk_info',
        'base_preventive_action',
        'risk_method_id',
        'base_severity_id',
        'base_probability_id',
        'base_frequency_id',
        'base_calc_risk',
        'prop_preventive_action',
        'prop_severity_id',
        'prop_probability_id',
        'prop_frequency_id',
        'prop_calc_risk',
        'create_date_time',
        'creator_id',
        'review_date',
        'auditor_id',
        'control_review_date',
        'risk_status',

    ];

    protected $allowedFilters = [
        'id',
        'unit_id',
        'hazard_info',
        'hazard_category_id',
        'injured_body_part_id',
        'base_risk_info',
        'base_preventive_action',
        'risk_method_id',
        'base_severity_id',
        'base_probability_id',
        'base_frequency_id',
        'base_calc_risk',
        'prop_preventive_action',
        'prop_severity_id',
        'prop_probability_id',
        'prop_frequency_id',
        'prop_calc_risk',
        'create_date_time',
        'creator_id',
        'review_date',
        'auditor_id',
        'control_review_date',
        'risk_status',

    ];

    protected $table = 'risks';

    public function unit(){
        return $this->belongsTo(Unit::class);
    }
    public function territories(){
        return $this->belongsToMany(Territory::class, 'risk_territory');
    }
    public function departments(){
        return $this->belongsToMany(Department::class);
    }
    public function positions(){
        return $this->belongsToMany(Position::class);
    }
    public function activities(){
        return $this->belongsToMany(Activity::class);
    }

    public function authors(){ //Authors of risks
        return $this->belongsToMany(Worker::class, 'author_risk');
    }

    public function creator(){
        return $this->belongsTo(User::class);
    }
    public function auditor(){
        return $this->belongsTo(User::class);
    }


    public function actions(){
        return $this->belongsToMany(Action::class);
    }

    public function hazardCategory(){
        return $this->belongsTo(HazardCategory::class);
    }
    public function injuredBodyPart(){
        return $this->belongsTo(InjuredBodyPart::class);
    }
    public function riskMethod(){
        return $this->belongsTo(RiskMethod::class);
    }



    public function baseSeverity(){
        return $this->belongsTo(RiskSeverity::class);
    }
    public function baseProbability(){
        return $this->belongsTo(RiskProbability::class);
    }
    public function baseFrequency(){
        return $this->belongsTo(RiskFrequency::class);
    }
    public function baseCalcRisk(){
        return $this->belongsTo(RiskZone::class, 'base_calc_risk');
    }
    public function propSeverity(){
        return $this->belongsTo(RiskSeverity::class);
    }
    public function propProbability(){
        return $this->belongsTo(RiskProbability::class);
    }
    public function propFrequency(){
        return $this->belongsTo(RiskFrequency::class);
    }
    public function propCalcRisk(){
        return $this->belongsTo(RiskZone::class, 'prop_calc_risk');
    }

}
