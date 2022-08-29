<?php

namespace App\Models\Unit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Worker extends Model
{
    use HasFactory;
   // use AsSource, Attachable, Filterable;

    /**
     * @var array
     */

    protected $fillable = [

        'last_name',
        'first_name',
        'middle_name',
        'phone',
        'email',
        'personnel_number',
        'job_position_id',
        'department_id',
        'unit_id',
        'birthday',
        'status'
        ];
    protected $allowedSorts = [
        'last_name',
        'first_name',
        'job_position_id',
        'department_id',
        'unit_id',
        'status',
        'created_at',
        'updated_at'
    ];
    protected $allowedFilters = [
        'last_name',
        'first_name',
        'middle_name',
        'job_position_id',
        'department_id',
        'unit_id',
        'status',
        'created_at',
        'updated_at'
    ];
    protected $table = 'workers';

    //Relationships for unit
    public function jobPosition(){
        return $this->belongsTo(JobPosition::class, 'job_position_id');
    }
    public function department(){
        return $this->belongsTo(Department::class);
    }
    public function unit(){
        return $this->belongsTo(Unit::class);
    }
    public function fullName(): string
    {
        return $this->last_name . ' ' . $this->first_name . ' ' . $this->middle_name;
    }

}
