<?php

namespace HermesHerrera\StatusFlow\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use HermesHerrera\StatusFlow\Models\StatusFlow;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasStatusFlowTrait
{
    protected $statusFlow;

    private function cacheKey() : string
    {        
        return tenant('id') . '_status_flow';
    }

    private function init() : void
    {
        $this->statusFlow = Cache::remember($this->cacheKey(), config('status_flow.cache_seconds', now()->addHours(12)), function () : Collection  {
            return StatusFlow::active($this)->get();
        });
    }

    protected function statusDefault() : Attribute
    {
        $this->init();
        return Attribute::make(
            get: fn () : string => 
                $this->statusFlow
                    ->where('is_default', true)
                    ->last()
                    ->name ?? 'pending'
        );
    }

    protected function statusTitle() : Attribute
    {    
        $this->init();
        return Attribute::make(
            get: fn () : string => 
                $this->statusFlow
                    ->where('name', $this->status)
                    ->first()
                    ->title ?? $this->status
        );
    }

    protected function statusColor() : Attribute
    {
        $this->init();
        return Attribute::make(
            get: fn () : string => 
                $this->statusFlow
                    ->where('name', $this->status)
                    ->first()
                    ->color ?? config('status_flow.null_color')
        );
    }

    protected function statusIsEditable() : Attribute
    {
        $this->init();
        return Attribute::make(
            get: fn () : bool => 
                $this->statusFlow
                    ->where('name', $this->status)
                    ->first()
                    ->is_editable ?? true
        );
    }

    protected function statusIsFinalized() : Attribute
    {
        $this->init();
        return Attribute::make(
            get: fn () : bool =>
                $this->statusFlow
                    ->where('name', $this->status)
                    ->first()
                    ->is_finalized ?? false
        );
    }

    protected function statusIsNotifiable() : Attribute
    {
        $this->init();
        return Attribute::make(
            get: fn () : bool => 
                $this->statusFlow
                    ->where('name', $this->status)
                    ->first()
                    ->is_notifiable ?? false
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