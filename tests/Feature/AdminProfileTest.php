<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_profile(): void
    {
        $this->get(route('admin.profile.edit'))->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_update_email_and_password(): void
    {
        $admin = User::factory()->create([
            'email' => 'old@ixora.test',
            'password' => 'password',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.profile.update'), [
                'name' => 'Updated Admin',
                'email' => 'new@ixora.test',
                'current_password' => 'password',
                'password' => 'new-password-123',
                'password_confirmation' => 'new-password-123',
            ])
            ->assertRedirect();

        $admin->refresh();

        $this->assertSame('Updated Admin', $admin->name);
        $this->assertSame('new@ixora.test', $admin->email);
        $this->assertTrue(Hash::check('new-password-123', $admin->password));
    }

    public function test_profile_update_requires_current_password(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@ixora.test',
            'password' => 'password',
        ]);

        $this->actingAs($admin)
            ->from(route('admin.profile.edit'))
            ->put(route('admin.profile.update'), [
                'name' => $admin->name,
                'email' => 'changed@ixora.test',
                'current_password' => 'wrong-password',
            ])
            ->assertRedirect(route('admin.profile.edit'))
            ->assertSessionHasErrors('current_password');

        $this->assertSame('admin@ixora.test', $admin->fresh()->email);
    }
}
