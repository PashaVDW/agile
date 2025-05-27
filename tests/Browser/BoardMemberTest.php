<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\BoardMember;
use Spatie\Permission\Models\Role;

class BoardMemberTest extends DuskTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Ensure admin role exists
        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin']);
        }
    }

    private function createAdminUser(): User
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        return $user;
    }

    public function testIndex()
    {
        $user = $this->createAdminUser();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/admin/boards')
                ->assertPathIs('/admin/boards')
                ->assertSee('Voeg bestuur lid toe');
        });
    }

    public function testCreateBoardMember()
    {
        $user = $this->createAdminUser();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/admin/board/create')
                ->assertSee('Voeg bestuur lid toe')
                ->typeSlowly('name', 'John Doe')
                ->typeSlowly('role', 'Chairman')
                ->typeSlowly('description', 'This is a test board member.')
                ->press('Voeg bestuur lid toe')
                ->waitForLocation('/admin/boards')
                ->assertSee('John Doe');
        });
    }

    public function testShowBoardMember()
    {
        $user = $this->createAdminUser();
        $boardMember = BoardMember::factory()->create(['name' => 'John Doe']);

        $this->browse(function (Browser $browser) use ($user, $boardMember) {
            $browser->loginAs($user)
                ->visit('/admin/boards')
                ->pause(1000)
                ->assertSee($boardMember->name);
        });
    }

    public function testUpdateBoardMember()
    {
        $user = $this->createAdminUser();
        $boardMember = BoardMember::factory()->create([
            'name' => 'John Doe',
            'role' => 'Chairman',
            'description' => 'Before update',
        ]);

        $this->browse(function (Browser $browser) use ($user, $boardMember) {
            $browser->loginAs($user)
                ->visit('/admin/board/' . $boardMember->id)
                ->typeSlowly('name', 'Jane Doe')
                ->typeSlowly('role', 'Vice Chairman')
                ->typeSlowly('description', 'Updated description.')
                ->press('Bewerk bestuur lid')
                ->waitForLocation('/admin/boards')
                ->assertSee('Jane Doe');
        });
    }

    public function testDeleteBoardMember()
    {
        $user = $this->createAdminUser();
        $boardMember = BoardMember::factory()->create([
            'name' => 'Jane Doe',
            'role' => 'Vice Chairman',
            'description' => 'To be deleted',
        ]);

        $this->browse(function (Browser $browser) use ($user, $boardMember) {
            $browser->loginAs($user)
                ->visit('/admin/board/' . $boardMember->id)
                ->pause(1000)
                ->press('Bestuurslid verwijderen')
                ->pause(500)
                ->press('Doorgaan')
                ->waitForLocation('/admin/boards')
                ->assertDontSee('Jane Doe');
        });
    }
}
