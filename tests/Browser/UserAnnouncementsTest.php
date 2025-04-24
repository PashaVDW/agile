<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserAnnouncementsTest extends DuskTestCase
{
    public function testIndexAnnouncement()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('public.announcements.index')
                ->assertSee('Lees verder');
        });
    }
}
