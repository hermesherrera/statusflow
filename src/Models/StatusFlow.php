<?php

namespace HermesHerrera\StatusFlow\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class StatusFlow extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'title',
        'model',
        'active',
        'color',
        'is_default',
        'is_editable',
        'is_notification',
        'is_finalized',
    ];
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $query) {
            $query->orderBy('status_flows.model')
                ->orderBy('status_flows.name');
        });
    }

    public function scopeActive($query, ?object $model = null) : Builder
    {
        return $query->where('active', true)
            ->when($model, fn ($query) => $query->where('model', get_class($model)));
    }

    public function scopeSelectActive($query, string $model) : Collection
    {
        return $query->active()
            ->where('model', $model)
            ->get()
            ->pluck('title', 'id');
    }

    public function dependecy() : HasMany
    {
        return $this->hasMany(StatusFlowDependecy::class);
    }
}