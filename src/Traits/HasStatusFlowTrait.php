<?php

namespace HermesHerrera\StatusFlow\Traits;

use Illuminate\Support\Facades\Cache;
use HermesHerrera\StatusFlow\Models\StatusFlow;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasStatusFlowTrait
{
    private function cacheKey()
    {
        return sprintf(
            "%s/%s-%s",
            $this->getTable(),
            $this->getKey(),
            $this->updated_at->timestamp
        );
    }

    protected function statusDefault() : Attribute
    {
        return Attribute::make(
            get: fn () : string => 
                Cache::remember($this->cacheKey() . '_default_', config('status_flow.cache_seconds', 3600), function() {
                    return StatusFlow::select('name')
                        ->active($this)
                        ->where('is_default', true)
                        ->latest()
                        ->first()
                        ->name ?? 'pending';
                })
        );
    }

    protected function statusTitle() : Attribute
    {    
        return Attribute::make(
            get: fn () : string => 
                Cache::remember($this->cacheKey() . '_title_', config('status_flow.cache_seconds', 3600), function() {
                    return StatusFlow::select('title')
                        ->active($this)
                        ->where('name', $this->status)
                        ->first()
                        ->title ?? $this->status;
                })
        );
    }

    protected function statusColor() : Attribute
    {
        return Attribute::make(
            get: fn () : string => 
                Cache::remember($this->cacheKey() . '_color_', config('status_flow.cache_seconds', 3600), function() {
                    return StatusFlow::select('color')
                        ->active($this)
                        ->where('name', $this->status)
                        ->first()
                        ->color ?? config('status_flow.null_color');
                })
        );
    }

    protected function statusIsEditable() : Attribute
    {
        return Attribute::make(
            get: fn () : bool => 
                Cache::remember($this->cacheKey() . '_is_editable_', config('status_flow.cache_seconds', 3600), function() {
                    return StatusFlow::select('is_editable')
                        ->active($this)
                        ->where('name', $this->status)
                        ->first()
                        ->is_editable ?? true;
                })
        );
    }

    protected function statusIsFinalized() : Attribute
    {
        return Attribute::make(
            get: fn () : bool =>
                Cache::remember($this->cacheKey() . '_is_finalized_', config('status_flow.cache_seconds', 3600), function() {
                    return StatusFlow::select('is_finalized')
                        ->active($this)
                        ->where('name', $this->status)
                        ->first()
                        ->is_finalized ?? false;
                })
        );
    }

    protected function statusIsNotifiable() : Attribute
    {
        return Attribute::make(
            get: fn () : bool => 
                Cache::remember($this->cacheKey() . '_is_notifiable_', config('status_flow.cache_seconds', 3600), function() {
                    return StatusFlow::select('is_notifiable')
                        ->active($this)
                        ->where('name', $this->status)
                        ->first()
                        ->is_notifiable ?? false;
                })
        );
    }

    public function statusByStatus() : array
    {
        return StatusFlow::select('dependecy.title', 'dependecy.name')
            ->join('status_flow_dependecies', 'status_flow_dependecies.status_flow_id', '=', 'status_flows.id')
            ->leftjoin('status_flows as dependecy', 'status_flow_dependecies.status_flow_dependecy_id', '=', 'dependecy.id')
            ->where('status_flows.active', true)
            ->where('status_flows.name', $this->status)
            ->where('status_flows.model', get_class($this))
            ->pluck('dependecy.title', 'dependecy.name')
            ->toArray() ?? [];
    }
}