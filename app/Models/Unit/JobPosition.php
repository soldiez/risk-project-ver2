<?php

namespace App\Models\Unit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class JobPosition extends Model
{
    use HasFactory;
    // asSource, Filterable;
   // use NodeTrait;

    protected $fillable = [
        'parent_id',
        'department_id',
        'unit_id',
        'name',
        'grade',
        'info',
        'status'
    ];
    protected $allowedSorts = [
        'parent_id',
        'department_id',
        'unit_id',
        'name',
        'grade',
        'info',
        'status'
    ];

    protected $allowedFilters = [
        'parent_id',
        'department_id',
        'unit_id',
        'name',
        'grade',
        'info',
        'status'
    ];

    protected $table = 'job_positions';

    //Relationships for unit
    public function parent(){
        return $this->belongsTo(JobPosition::class);
    }
    public function department(){
        return $this->belongsTo(Department::class);
    }
    public function unit(){
        return $this->belongsTo(Unit::class);
    }
    public function workers(){
        return $this->hasMany(Worker::class);
    }
    //TODO think about one or many relationship for method bellow
    public function territoryResponsible(){
        return $this->hasOne(Territory::class);
    }
    public function departmentManager(){
        return $this->hasOne(Department::class);
    }
    public function unitManager(){
        return $this->hasOne(JobPosition::class);
    }
    public function safetyManager(){
        return $this->hasOne(JobPosition::class);
    }

}
