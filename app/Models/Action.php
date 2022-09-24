<?php

namespace App\Models;

use App\Models\Risk\Risk;
use App\Models\Unit\Department;
use App\Models\Unit\Position;
use App\Models\Unit\Territory;
use App\Models\Unit\Unit;
use App\Models\Unit\Worker;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use PhpParser\Node\Expr\Ternary;

class Action extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'parent_id',
        'unit_id',
        'type',
        'name',
        'description',
        'priority',
        'responsible_id',
        'plan_date',
        'start_date',
        'due_date',
        'photo_before',
        'photo_after',
        'creator_id',
        'status',
    ];
    protected $allowedSorts = [
        'id',
        'parent_id',
        'unit_id',
        'type',
        'name',
        'description',
        'priority',
        'responsible_id',
        'plan_date',
        'start_date',
        'due_date',
        'photo_before',
        'photo_after',
        'creator_id',
        'status',
    ];

    protected $allowedFilters = [
        'id',
        'parent_id',
        'unit_id',
        'type',
        'name',
        'description',
        'priority',
        'responsible_id',
        'plan_date',
        'start_date',
        'due_date',
        'photo_before',
        'photo_after',
        'creator_id',
        'status',
    ];
    protected $table = 'actions';

    public function parent(){
       return $this->belongsTo(Action::class, 'parent_id');
    }

    public function children(){
        return $this->hasMany(Action::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function responsible(){
        return $this->belongsTo(Worker::class);
    }

    public function creator(){
        return $this->belongsTo(User::class);
    }

    public function territories(){
        return $this->belongsToMany(Territory::class);
    }

    public function departments(){
        return $this->belongsToMany(Department::class);
    }

    public function positions(){
        return $this->belongsToMany(Position::class);
    }

    public function workers(){
        return $this->belongsToMany(Worker::class);
    }

    public function risks(){
        return $this->belongsToMany(Risk::class);
    }

}
