<?php

namespace HermesHerrera\StatusFlow\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StatusFlowDependecy extends Model
{
    protected $fillable = [
        'status_flow_id',
        'status_flow_dependecy_id',
    ];

    public function status() : BelongsTo
    {
        return $this->belongsTo(StatusFlow::class, 'status_flow_dependecy_id');
    }
}