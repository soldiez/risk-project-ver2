<?php

namespace App\Models\Unit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


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
    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(JobPosition::class);
    }
    public function department(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
    public function unit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
    public function workers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Worker::class);
    }
    //TODO think about one or many relationship for method bellow
    public function territoryResponsible(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Territory::class);
    }
    public function departmentManager(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Department::class);
    }
    public function unitManager(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(JobPosition::class);
    }
    public function safetyManager(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(JobPosition::class);
    }

}
