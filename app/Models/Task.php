<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * @var array
     */
    public const STATUS = [
        'to-do' => 'To-do',
        'in-progress' => 'In-progress',
        'done' => 'Done',
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'content',
        'status',
        'published',
        'attachment',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'user_id',
        'title',
        'content',
        'status',
        'published',
        'attachment',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that will be casted
     *
     * @var array
     */
    protected $casts = [
        'published' => 'boolean',
    ];

    public function scopeOwnTask(Builder $query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeStatus(Builder $query, ?string $status = null)
    {
        return $query->when(!empty($status), fn ($query) => (
            $query->where('status', $status)
        ));
    }
}
