<?php

namespace App\Mixins;

use Closure;
use Illuminate\Testing\Fluent\AssertableJson;

class AssertableJsonMixin
{
    public function hasPagination(): Closure
    {
        return function (): AssertableJson {
            /** @var AssertableJson $this */
            return $this
                ->has('pagination', fn(AssertableJson $json) => $json
                    ->whereType('current_page_items', 'integer')
                    ->whereType('current_page_number', 'integer')
                    ->whereType('last_page_number', 'integer')
                    ->whereType('items_per_page', 'integer')
                    ->whereType('total_items', 'integer')
                );
        };
    }
}
