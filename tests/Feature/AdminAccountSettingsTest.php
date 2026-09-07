<?php

namespace Tests\Feature;

use App\Filament\Pages\AdminAccountSettings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class AdminAccountSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_name_and_password(): void
    {
        $user = User::factory()->create([
            'name' => 'Admin Lama',
            'email' => 'admin@example.com',
            'password' => Hash::make('old-password'),
        ]);

        Livewire::actingAs($user)
            ->test(AdminAccountSettings::class)
            ->set('data.name', 'Admin Baru')
            ->set('data.password', 'new-password-123')
            ->set('data.passwordConfirmation', 'new-password-123')
            ->set('data.currentPassword', 'old-password')
            ->call('save')
            ->assertHasNoErrors();

        $user->refresh();

        $this->assertSame('Admin Baru', $user->name);
        $this->assertTrue(Hash::check('new-password-123', $user->password));
    }
}
