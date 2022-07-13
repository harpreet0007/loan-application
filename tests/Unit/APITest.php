<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Chrome;
use Tests\DuskTestCase;

class APITest extends TestCase
{
    public function testCheckLoginPage()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }
    
}
