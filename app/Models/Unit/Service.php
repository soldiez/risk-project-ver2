<?php

namespace App\Models\Unit;

use App\Models\Risk\Risk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'unit_id',
        'name',
        'description',
        'parent_id',
        'status',
    ];
    protected $allowedSorts = [
        'id',
        'unit_id',
        'name',
        'description',
        'parent_id',
        'status',
    ];

    protected $allowedFilters = [
        'id',
        'unit_id',
        'name',
        'description',
        'parent_id',
        'status',
    ];
    protected $table = 'services';

    public function unit(){
        return $this->belongsTo(Unit::class);
    }
    public function parent(){
        return $this->belongsTo(Service::class, 'parent_id');
    }
    public function territories(){
        return $this->belongsToMany(Territory::class, 'activity_unit');
    }
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'activity_unit');
    }
    public function positions(){
        return $this->belongsToMany(Position::class, 'activity_unit');
    }
    public function workers(){
        return $this->belongsToMany(Worker::class, 'activity_unit');
    }
    public function risks(){
        return $this->belongsToMany(Risk::class, 'activity_unit');
    }
}
