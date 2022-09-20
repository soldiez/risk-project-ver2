<?php

namespace App\Models\Unit;

use App\Models\Risk\Risk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Position extends Model
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

    protected $table = 'positions';

    //Relationships for unit
    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Position::class, 'parent_id');
    }
    public function positions(){
        return $this->hasMany(Position::class);
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
    public function processes(){
        return $this->belongsToMany(Process::class, 'activity_unit');
    }
    public function products(){
        return $this->belongsToMany(Product::class, 'activity_unit');
    }
    public function services(){
        return $this->belongsToMany(Service::class, 'activity_unit');
    }

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
        return $this->hasOne(Position::class);
    }
    public function safetyManager(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Position::class);
    }

    public function risks(){
        return $this->belongsToMany(Risk::class);
    }



}
