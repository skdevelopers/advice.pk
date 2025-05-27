<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
// Boot the full Laravel app & refresh the database for all feature tests
uses(TestCase::class, RefreshDatabase::class)
    ->in('Feature');

abstract class TestCase extends BaseTestCase
{
    //
}
