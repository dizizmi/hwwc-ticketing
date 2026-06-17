<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_can_login(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
            'role' => 'admin'
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password123'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['token']);
    }

    public function test_invalid_credentials_rejected(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'wrong@email.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertStatus(401);
    }
}
