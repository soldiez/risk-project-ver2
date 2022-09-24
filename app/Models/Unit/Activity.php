<?php

namespace App\Models\Unit;

use App\Models\Risk\Risk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'parent_id',
        'unit_id',
        'type',
        'name',
        'description',
        'status',
    ];
    protected $allowedSorts = [
        'id',
        'parent_id',
        'unit_id',
        'type',
        'name',
        'description',
        'status',
    ];

    protected $allowedFilters = [
        'id',
        'parent_id',
        'unit_id',
        'type',
        'name',
        'description',
        'status',
    ];
    protected $table = 'activities';

    public function unit(){
        return $this->belongsTo(Unit::class);
    }
    public function parent(){
        return $this->belongsTo(Activity::class, 'parent_id');
    }
    public function territories(){
        return $this->belongsToMany(Territory::class);
    }
    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }
    public function positions(){
        return $this->belongsToMany(Position::class);
    }
//    public function workers(){
//        return $this->belongsToMany(Worker::class, 'activity_unit');
//    }
    public function risks(){
        return $this->belongsToMany(Risk::class);
    }



}
