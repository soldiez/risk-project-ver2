<?php

namespace App\Models\Unit;

use App\Models\Risk\Risk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


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

    //Relationships for department
    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }
    public function departments(){
        return $this->hasMany(Department::class);
    }

    public function unit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
    public function manager(){
        return $this->belongsTo(Position::class);
    }

    public function positions(){
        return $this->hasMany(Position::class);
    }
    public function workers(){
        return $this->hasMany(Worker::class);
    }
    public function territories(){
        return $this->belongsToMany(Territory::class, 'department_territory');
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


    //Relationships for risks

    public function risks(){
        return $this->belongsToMany(Risk::class);
    }


}
