<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class UserEventsTest extends DuskTestCase
{
    public function testIndexEvent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('user.events.index')
                ->assertSee('Lees verder');
        });
    }

    public function testShowEvent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('user.event.show', 1)
                ->assertSee('Event');
        });
    }
}
