<?php

namespace App\Models;

/**
 * 操作日志
 *
 * Class Log
 * @package App\Models
 */
class AdminLog extends Model
{
    protected $table = "operation_log";
    protected $guarded = [];

    /**
     * 操作用户
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}