<?php

namespace HermesHerrera\StatusFlow\Rules;

use Closure;
use HermesHerrera\StatusFlow\Models\StatusFlow;
use Illuminate\Contracts\Validation\ValidationRule;

class OnlyOneDefaultStatusRule implements ValidationRule
{
    public function __construct(
        protected int|null $id,
        protected bool $is_default,
    )
    {}
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        (int) $count = StatusFlow::when(!$this->id, fn ($query) => $query->where('id', '<>', $this->id))
            ->where('model', $value)
            ->where('is_default', true)
            ->count();
            
        if ( $this->is_default && $count > 0 ) {
            $fail(__('StatusFlow::validation.only_one_default_status'));
        }
    }
}
