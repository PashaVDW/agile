<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Announcement;

class AnnouncementTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * Test het aanmaken van een nieuwe aankondiging.
     */
    public function testCreateAnnouncement()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin/announcements/create')
                ->type('title', 'Nieuwe Aankondiging')
                ->type('description', 'Dit is een testaankondiging.')
                ->press('Aanmaken')
                ->assertSee('Aankondiging succesvol aangemaakt!');
        });
    }

    /**
     * Test het bewerken van een bestaande aankondiging.
     */
    public function testEditAnnouncement()
    {
        $announcement = Announcement::factory()->create();

        $this->browse(function (Browser $browser) use ($announcement) {
            $browser->visit("/admin/announcements/{$announcement->id}/edit")
                ->type('title', 'Gewijzigde Titel')
                ->press('Bijwerken')
                ->assertSee('Aankondiging succesvol bijgewerkt!');
        });
    }

    /**
     * Test het verwijderen van een aankondiging.
     */
    public function testDeleteAnnouncement()
    {
        $announcement = Announcement::factory()->create();

        $this->browse(function (Browser $browser) use ($announcement) {
            $browser->visit('/admin/announcements')
                ->click('@delete-announcement-'.$announcement->id)
                ->acceptDialog()
                ->assertSee('Aankondiging succesvol verwijderd!');
        });
    }
}
