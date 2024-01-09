<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class TaskStatus extends Model
{
    use HasFactory, SoftDeletes, Cachable;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $table = 'tasks_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'is_active',
        'deleted_by',
        'updated_by',
        'created_by',
    ];

    public function roles(): HasOne
    {
        return $this->hasOne(Task::class, 'task_status_id', 'id');
    }
}
