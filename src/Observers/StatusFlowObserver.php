<?php

namespace HermesHerrera\StatusFlow\Observers;

use Illuminate\Support\Facades\Cache;
use HermesHerrera\StatusFlow\Models\StatusFlow;
use HermesHerrera\StatusFlow\Traits\HasStatusFlowTrait;

class StatusFlowObserver
{
    use HasStatusFlowTrait;
    /**
     * Handle the Comment "updated" event.
     */
    public function updated(StatusFlow $statusFlow): void
    {
        Cache::forget($this->cacheKey());
    }
}