<?php

namespace App\Providers;

use ReflectionException;
use App\Mixins\BuilderMixin;
use App\Mixins\FactoryMixin;
use App\Mixins\AssertableJsonMixin;
use App\Mixins\ResponseFactoryMixin;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Database\Eloquent\Factories\Factory;

class MixinServiceProvider extends ServiceProvider
{
    /**
     * @throws ReflectionException
     */
    public function boot(): void
    {
        Builder::mixin(new BuilderMixin);
        ResponseFactory::mixin(new ResponseFactoryMixin);
        AssertableJson::mixin(new AssertableJsonMixin);
        Factory::mixin(new FactoryMixin);
    }
}
