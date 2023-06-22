<?php

namespace HermesHerrera\StatusFlow\Traits;

use HermesHerrera\StatusFlow\Models\StatusFlow;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasStatusFlowTrait
{
    protected function statusDefault() : Attribute
    {
        return Attribute::make(
            get: fn () : string => 
                StatusFlow::select('name')
                    ->active($this)
                    ->where('is_default', true)
                    ->latest()
                    ->first()
                    ->name ?? 'pending',
        );
    }

    protected function statusTitle() : Attribute
    {
        return Attribute::make(
            get: fn () : string => 
                StatusFlow::select('title')
                    ->active($this)
                    ->where('name', $this->status)
                    ->first()
                    ->title ?? $this->status,
        );
    }

    protected function statusColor() : Attribute
    {
        return Attribute::make(
            get: fn () : string => 
                StatusFlow::select('color')
                    ->active($this)
                    ->where('name', $this->status)
                    ->first()
                    ->color ?? config('status_flow.null_color'),
        );
    }

    protected function statusIsEditable() : Attribute
    {
        return Attribute::make(
            get: fn () : bool => 
                StatusFlow::select('is_editable')
                    ->active($this)
                    ->where('name', $this->status)
                    ->first()
                    ->is_editable ?? true,
        );
    }

    protected function statusIsFinalized() : Attribute
    {
        return Attribute::make(
            get: fn () : bool => 
                StatusFlow::select('is_finalized')
                    ->active($this)
                    ->where('name', $this->status)
                    ->first()
                    ->is_finalized ?? false,
        );
    }

    protected function statusIsNotifiable() : Attribute
    {
        return Attribute::make(
            get: fn () : bool => 
                StatusFlow::select('is_notifiable')
                    ->active($this)
                    ->where('name', $this->status)
                    ->first()
                    ->is_notifiable ?? false,
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