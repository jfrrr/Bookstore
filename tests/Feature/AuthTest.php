<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_login_page(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Masuk');
    }

    public function test_user_can_view_register_page(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Daftar Akun');
    }

    public function test_user_can_register_successfully(): void
    {
        $response = $this->post('/register', [
            'name'                  => 'John Doe',
            'email'                 => 'john@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email'    => 'testuser@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->post('/login', [
            'email'    => 'testuser@example.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_password(): void
    {
        $user = User::factory()->create([
            'email'    => 'testuser@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->post('/login', [
            'email'    => 'testuser@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect(route('home'));
        $this->assertGuest();
    }

    public function test_user_can_view_forgot_password_page(): void
    {
        $response = $this->get('/forgot-password');
        $response->assertStatus(200);
        $response->assertSee('Lupa Password Anda?');
    }

    public function test_user_can_request_password_reset_link(): void
    {
        $user = User::factory()->create(['email' => 'resetme@example.com']);

        $response = $this->post('/forgot-password', [
            'email' => 'resetme@example.com',
        ]);

        $response->assertSessionHas('status');
        $this->assertDatabaseHas('password_reset_tokens', [
            'email' => 'resetme@example.com',
        ]);
    }

    public function test_user_can_reset_password_with_valid_token(): void
    {
        $user = User::factory()->create(['email' => 'resetme@example.com']);
        $token = \Illuminate\Support\Facades\Password::broker()->createToken($user);

        $response = $this->post('/reset-password', [
            'token'                 => $token,
            'email'                 => 'resetme@example.com',
            'password'              => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');

        $this->assertTrue(
            \Illuminate\Support\Facades\Hash::check('newpassword123', $user->fresh()->password)
        );
    }
}
