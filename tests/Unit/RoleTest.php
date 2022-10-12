<?php

namespace Tests\Unit;

use Tests\TestCase;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test  */
    public function roles_can_be_created()
    {
        $this->seed(RoleSeeder::class);

        $this->assertDatabaseCount('roles', 3);
    }
}
