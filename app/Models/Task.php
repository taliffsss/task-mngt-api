<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Task extends Model
{
    use HasFactory, SoftDeletes, Cachable;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'task_status_id',
        'ordering',
        'deleted_by',
        'updated_by',
        'created_by',
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(TaskStatus::class);
    }
}
