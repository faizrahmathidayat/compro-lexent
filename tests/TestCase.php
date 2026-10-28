<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        // Pages call the CMS on every request (navbar included); never reach a
        // real dashboard from tests. Http::fake() patterns still match this host.
        config(['services.cms.base_url' => 'http://cms.test']);
    }
}
