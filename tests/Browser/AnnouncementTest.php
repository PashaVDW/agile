<?php

namespace Tests\Browser;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AnnouncementTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_create_announcement()
    {
        $admin = User::where('email', 'admin@agile.nl')->first();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                ->visit('admin/announcement/create')
                ->waitFor('#title')
                ->type('title', 'Nieuwe Aankondiging')
                ->type('description', 'Dit is een testaankondiging.')
                ->press('Aanmaken')
                ->pause(1000)
                ->assertSee('Nieuwe Aankondiging')
                ->screenshot('announcement-create')
                ->dump();
        });
    }

    public function test_edit_announcement()
    {
        $admin = User::where('email', 'admin@agile.nl')->first();
        $announcement = Announcement::factory()->create([
            'title' => 'Oude Titel',
            'description' => 'Origineel',
        ]);

        $this->browse(function (Browser $browser) use ($announcement, $admin) {
            $browser->loginAs($admin)
                ->visit("admin/announcement/{$announcement->id}/edit")
                ->waitFor('#title')
                ->type('title', 'Gewijzigde Titel')
                ->type('description', 'Gewijzigde omschrijving')
                ->press('Bijwerken')
                ->pause(1000)
                ->assertSee('Gewijzigde Titel')
                ->screenshot('announcement-edit')
                ->dump();
        });
    }

    public function test_delete_announcement()
    {
        $admin = User::where('email', 'admin@agile.nl')->first();
        $announcement = Announcement::factory()->create([
            'title' => 'Te Verwijderen Aankondiging',
        ]);

        $this->browse(function (Browser $browser) use ($announcement, $admin) {
            $browser->loginAs($admin)
                ->visit("admin/announcement/{$announcement->id}/edit")
                ->waitFor("@delete-announcement-{$announcement->id}")
                ->click("@delete-announcement-{$announcement->id}")
                ->pause(500) // wait for modal animation if any
                ->script("document.querySelector('form[action$=\"/delete/{$announcement->id}\"]').submit();");

            $browser->pause(1000)
                ->visit('admin/announcements')
                ->assertDontSee('Te Verwijderen Aankondiging')
                ->screenshot('announcement-delete')
                ->dump();
        });
    }
}
