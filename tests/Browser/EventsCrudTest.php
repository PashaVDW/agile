<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class EventsCrudTest extends DuskTestCase
{
    public function testIndex()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('admin.events.index')
                ->assertSee('Events');
        });
    }

    public function testCreateEvent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('admin.event.create');
                $browser->typeSlowly('title', 'test')
                    ->typeSlowly('description', 'test')
                    ->type('date', '01-01-2026')
                    ->select('category', 'drinks')
                    ->typeSlowly('price', '10')
                    ->typeSlowly('capacity', '10')
                    ->attach('image', storage_path('app/public/images/banner-2.jpg')) // change image to your own
                    ->press('Add event')
                    ->waitForLocation(route('admin.events.index'))
                    ->assertSee('test');
        });
    }

    public function testShowEvent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('admin.event.show', 1)
                ->assertSee('Event');
        });
    }

    public function testUpdateEvent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('admin.event.show', 1)
                ->typeSlowly('title', 'test2')
                ->typeSlowly('description', 'test2')
                ->type('date', '01-01-2027')
                ->select('category', 'events')
                ->typeSlowly('price', '20')
                ->typeSlowly('capacity', '20')
                ->press('Update event')
                ->waitForLocation(route('admin.events.index'))
                ->assertSee('test');
        });
    }

    public function testDeleteEvent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('admin.event.show', 1)
                ->press('Delete event')
                ->waitForLocation(route('admin.events.index'))
                ->assertDontSee('test2');
        });
    }
}
