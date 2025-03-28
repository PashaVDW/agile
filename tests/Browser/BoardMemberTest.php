<?php

namespace Tests\Browser;


use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\BoardMember;

// to run tests indivdualy uncomment the login lines of an test, if the first tests login in uncommented all subsequent should function
class BoardMemberTest extends DuskTestCase
{
    public function testIndex()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->typeSlowly('email', 'admin@agile.nl')
                ->typeSlowly('password', 'test1234')
                ->press('Inloggen')
                ->visit('/admin/boards')
                ->assertPathIs('/admin/boards')
                ->assertSee('Voeg bestuur lid toe');
        });
    }

    public function testCreateBoardMember()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
//                ->typeSlowly('email', 'admin@agile.nl')
//                ->typeSlowly('password', 'test1234')
//                ->press('Inloggen')
                ->visit('/admin/board/create')
                ->assertSee('Voeg bestuur lid toe')
                ->typeSlowly('name', 'John Doe')
                ->typeSlowly('role', 'Chairman')
                ->typeSlowly('description', 'This is a test board member.')
//                ->attach('image', storage_path('app/public/images/test-image.jpg'))
                ->press('Voeg bestuur lid toe');


            $browser->waitForLocation('/admin/boards')
                ->assertSee('John Doe');
        });
    }

    public function testShowBoardMember()
    {
        $boardMember = BoardMember::first(); // Ensure there's a board member

        $this->browse(function (Browser $browser) use ($boardMember) {
            $browser->visit('/login')
//                ->typeSlowly('email', 'admin@agile.nl')
//                ->typeSlowly('password', 'test1234')
//                ->press('Inloggen')
                ->visit('/admin/boards/')
                ->pause(2000)
                ->assertSee($boardMember->name);
        });
    }

    public function testUpdateBoardMember()
    {
        $boardMember = BoardMember::first();

        $this->browse(function (Browser $browser) use ($boardMember) {
            $browser->visit('/login')
//                ->typeSlowly('email', 'admin@agile.nl')
//                ->typeSlowly('password', 'test1234')
//                ->press('Inloggen')
                ->visit('/admin/board/' . $boardMember->id)
                ->typeSlowly('name', 'Jane Doe')
                ->typeSlowly('role', 'Vice Chairman')
                ->typeSlowly('description', 'Updated description.')
//                ->attach('image', storage_path('app/public/images/new-image.jpg'))
                ->press('Bewerk bestuur lid');

            $browser->waitForLocation('/admin/boards')
                ->assertSee('Jane Doe');
        });
    }

    public function testDeleteBoardMember()
    {
        $boardMember = BoardMember::first();

        $this->browse(function (Browser $browser) use ($boardMember) {
            $browser->visit('/login')
//                ->typeSlowly('email', 'admin@agile.nl')
//                ->typeSlowly('password', 'test1234')
//                ->press('Inloggen')
                ->visit('/admin/board/' . $boardMember->id)
                ->pause(2000)
                ->press('Verwijder bestuur lid')
                ->waitForLocation('/admin/boards')
                ->assertDontSee('Jane Doe');
        });
    }
}
