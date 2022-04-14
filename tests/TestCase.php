<?php

namespace Tests;

use Tests\Traits\Authenticate;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * @method setUpUser()
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUpTraits()
    {
        $uses = parent::setUpTraits();

        if (isset($uses[Authenticate::class])) {
            $this->setUpUser();
        }
    }
}
