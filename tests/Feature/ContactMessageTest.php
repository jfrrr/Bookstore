<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_submit_contact_message(): void
    {
        $response = $this->post('/contact', [
            'name'    => 'Pengunjung Web',
            'email'   => 'pengunjung@example.com',
            'subject' => 'Tanya Ketersediaan',
            'message' => 'Halo, apakah buku Atomic Habits tersedia?',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'name'    => 'Pengunjung Web',
            'email'   => 'pengunjung@example.com',
            'subject' => 'Tanya Ketersediaan',
            'status'  => 'unread',
        ]);
    }

    public function test_admin_can_view_contact_messages(): void
    {
        $admin = User::factory()->admin()->create();

        ContactMessage::create([
            'name'    => 'Customer Test',
            'email'   => 'test@example.com',
            'subject' => 'Keluhan Layanan',
            'message' => 'Pesan pengujian untuk admin panel.',
            'status'  => 'unread',
        ]);

        $response = $this->actingAs($admin)->get('/admin/messages');
        $response->assertStatus(200);
        $response->assertSee('Customer Test');
        $response->assertSee('Keluhan Layanan');
    }

    public function test_admin_viewing_message_marks_it_as_read(): void
    {
        $admin = User::factory()->admin()->create();

        $message = ContactMessage::create([
            'name'    => 'Customer Test',
            'email'   => 'test@example.com',
            'subject' => 'Pertanyaan Pembayaran',
            'message' => 'Apakah bisa bayar pakai COD?',
            'status'  => 'unread',
        ]);

        $response = $this->actingAs($admin)->get("/admin/messages/{$message->id}");
        $response->assertStatus(200);

        $this->assertDatabaseHas('contact_messages', [
            'id'     => $message->id,
            'status' => 'read',
        ]);
    }

    public function test_admin_can_toggle_read_status(): void
    {
        $admin = User::factory()->admin()->create();

        $message = ContactMessage::create([
            'name'    => 'Customer Test',
            'email'   => 'test@example.com',
            'subject' => 'Pertanyaan',
            'message' => 'Isi pesan tes pengujian.',
            'status'  => 'read',
        ]);

        $response = $this->actingAs($admin)->patch("/admin/messages/{$message->id}/toggle-read");
        $response->assertRedirect();

        $this->assertDatabaseHas('contact_messages', [
            'id'     => $message->id,
            'status' => 'unread',
        ]);
    }

    public function test_admin_can_delete_contact_message(): void
    {
        $admin = User::factory()->admin()->create();

        $message = ContactMessage::create([
            'name'    => 'Customer Test',
            'email'   => 'test@example.com',
            'subject' => 'Pesan Sampah',
            'message' => 'Pesan yang akan dihapus.',
            'status'  => 'read',
        ]);

        $response = $this->actingAs($admin)->delete("/admin/messages/{$message->id}");
        $response->assertRedirect('/admin/messages');

        $this->assertDatabaseMissing('contact_messages', [
            'id' => $message->id,
        ]);
    }

    public function test_regular_user_cannot_access_admin_messages(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/messages');
        $response->assertStatus(403);
    }
}
