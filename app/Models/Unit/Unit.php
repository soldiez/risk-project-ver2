<?php

namespace App\Models\Unit;

use App\Models\Risk\Risk;
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
        'short_name',
        'long_name',
        'phone_main',
        'phone_reserve',
        'email',
        'manager_id',
        'safety_manager_id',
        'legal_address',
        'post_address',
        'parent_id',
        'status',
        'logo_unit'
    ];
    protected $allowedSorts = [
        'id',
        'short_name',
        'long_name',
        'phone_main',
        'phone_reserve',
        'email',
        'manager_id',
        'safety_manager_id',
        'legal_address',
        'post_address',
        'parent_id',
        'status'
    ];

    protected $allowedFilters = [
        'id',
        'short_name',
        'long_name',
        'phone_main',
        'phone_reserve',
        'email',
        'manager_id',
        'safety_manager_id',
        'legal_address',
        'post_address',
        'parent_id',
        'status'
    ];
    protected $table = 'units';

    //Relationships for unit
    public function parent(){
        return $this->belongsTo(Unit::class, 'parent_id');
    }
    public function territories(){
        return $this->hasMany(Territory::class);
    }
    public function departments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Department::class);
    }
    public function jobPositions(){
        return $this->hasMany(JobPosition::class);
    }
    public function workers(){
        return $this->hasMany(Worker::class);
    }
    public function manager(){
        return $this->belongsTo(JobPosition::class, 'manager_id');
    }
    public function safetyManager(){
        return $this->belongsTo(JobPosition::class, 'safety_manager_id');
    }

    //Relationships for risks

//delete child contain
    public static function boot() {
        parent::boot();

        static::deleting(function($unit) { // before delete() method call this
            $unit->departments()->delete();
            $unit->territories()->delete();
            $unit->jobPositions()->delete();
            $unit->workers()->delete();
        });
    }



}
