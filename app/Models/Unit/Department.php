<?php

namespace App\Models\Unit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Department extends Model
{
    use HasFactory //asSource, Filterable
        ;
   // use NodeTrait;

    protected $fillable = [
        'parent_id',
        'unit_id',
        'name',
        'manager_id',
        'info',
        'status'

    ];
    protected $allowedSorts = [
        'parent_id',
        'unit_id',
        'name',
        'manager_id',
        'info',
        'status'
    ];

    protected $allowedFilters = [
        'parent_id',
        'unit_id',
        'name',
        'manager_id',
        'info',
        'status'
    ];

    protected $table = 'departments';

    //Relationships for unit
    public function parent(){
        return $this->belongsTo(Department::class);
    }
    public function unit(){
        return $this->belongsTo(Unit::class);
    }
    public function manager(){
        return $this->belongsTo(JobPosition::class);
    }

    public function jobPositions(){
        return $this->hasMany(JobPosition::class);
    }
    public function workers(){
        return $this->hasMany(Worker::class);
    }
    public function territories(){
        return $this->belongsToMany(Territory::class, 'department_territory');
    }
    //Relationships for risks

//    public function risks(){
//        return $this->hasMany(Risk::class);
//    }


}
