<?php

namespace App\Models\Unit;

use App\Models\Action;
use App\Models\Risk\Risk;
use App\Models\Risk\RiskMethod;
use App\Models\Unit\Department;
use App\Models\Unit\Territory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Unit extends Model
{
    use HasFactory;
  //  use AsSource, Attachable, Filterable;

    protected $fillable = [
        'id',
        'name',
        'long_name',
        'phone_main',
        'phone_reserve',
        'email',
        'manager_id',
        'safety_manager_id',
        'legal_address',
        'post_address',
        'parent_id',
        'default_risk_method_id',
        'status',
        'logo_unit'
    ];
    protected $allowedSorts = [
        'id',
        'name',
        'long_name',
        'phone_main',
        'phone_reserve',
        'email',
        'manager_id',
        'safety_manager_id',
        'legal_address',
        'post_address',
        'parent_id',
        'default_risk_method_id',
        'status'
    ];

    protected $allowedFilters = [
        'id',
        'name',
        'long_name',
        'phone_main',
        'phone_reserve',
        'email',
        'manager_id',
        'safety_manager_id',
        'legal_address',
        'post_address',
        'parent_id',
        'default_risk_method_id',
        'status'
    ];
    protected $table = 'units';

    //Relationships for unit
    public function parent(){
        return $this->belongsTo(Unit::class, 'parent_id');
    }
    public function units(){
        return $this->hasMany(Unit::class, 'id');
    }

    public function territories(){
        return $this->hasMany(Territory::class);
    }
    public function departments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Department::class);
    }
    public function positions(){
        return $this->hasMany(Position::class);
    }
    public function workers(){
        return $this->hasMany(Worker::class);
    }
    public function activities(){
        return $this->hasMany(Activity::class);
    }
    public function actions(){
        return $this->hasMany(Action::class);
    }



    public function manager(){
        return $this->belongsTo(Worker::class, 'manager_id');
    }
    public function safetyManager(){
        return $this->belongsTo(Worker::class, 'safety_manager_id');
    }

    //Relationships for risks
    public function risks(){
        return $this->hasMany(Risk::class);
    }

    public function riskMethods(){
        return $this->belongsToMany(RiskMethod::class, 'risk_method_unit');
    }

    public function defaultRiskMethod(){
        return $this->belongsTo(RiskMethod::class, 'default_risk_method_id');
    }

//delete child contain
    public static function boot() {
        parent::boot();

        static::deleting(function($unit) { // before delete() method call this
            $unit->departments()->delete();
            $unit->territories()->delete();
            $unit->positions()->delete();
            $unit->workers()->delete();
            $unit->processes()->delete();
            $unit->products()->delete();
            $unit->services()->delete();
        });
    }



}
