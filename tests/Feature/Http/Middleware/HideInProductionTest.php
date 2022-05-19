<?php

namespace Tests\Feature\Http\Middleware;

use Tests\TestCase;
use Tests\Traits\Authenticate;
use Illuminate\Support\Facades\Config;

class HideInProductionTest extends TestCase
{
    use Authenticate;

    public function testHidesProtectedRouteInProduction(): void
    {
        Config::set('debug', false);

        $this
            ->get(route('docs'))
            ->assertNotFound();
    }
}
