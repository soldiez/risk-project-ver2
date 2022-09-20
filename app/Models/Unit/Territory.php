<?php

namespace App\Models\Unit;

use App\Models\Risk\Risk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kalnoy\Nestedset\NodeTrait;


class Territory extends Model
{
    use HasFactory;
   // use NodeTrait;
   // use asSource, Filterable;

    protected $attributes = [
        'status' => 'Active'
    ];

    protected $fillable = [
        'parent_id',
        'name',
        'unit_id',
        'responsible_id',
        'coordinate',
        'address',
        'info',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $allowedSorts = [
        'parent_id',
        'name',
        'unit_id',
        'responsible_id',
        'coordinate',
        'address',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $allowedFilters = [
        'parent_id',
        'name',
        'unit_id',
        'responsible_id',
        'coordinate',
        'address',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $table = 'territories';

    //Relationships for Unit

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
    public function parent(){
        return $this->belongsTo(Territory::class, 'parent_id');
    }
    public function responsible(){
        return $this->belongsTo(Position::class, 'responsible_id');
    }

    public function territories(){
        return $this->hasMany(Territory::class);
    }

    public function departments(){
        return $this->belongsToMany(Department::class, 'department_territory');
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


    //Relationships for Risks

    public function risks(){
        return $this->belongsToMany(Risk::class);
    }
//
//    Public function children(){
//        return $this->hasMany(Territory::class);
//    }
//    public function childrenRecursive(){
//        return $this->children()->with('childrenRecursive');
//    }
//    public function categories(){
//        return $this->hasMany(Territory::class, 'parent_id', 'id');
//    }
//    public function childrenCategories(){
//        return $this->hasMany(Territory::class, 'parent_id', 'id')->with('categories');
//    }

}
