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
                    ->attach('banner', storage_path('app/public/images/banner-2.jpg')) // change image to your own
                    ->typeSlowly('payment_link', 'test');

                    $browser->script([
                        'document.getElementById("submitButton").scrollIntoView()',
                        'document.getElementById("submitButton").click()'
                    ]);

                    $browser->waitForLocation(route('admin.events.index'))
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
            $browser->visitRoute('admin.event.show', 2)
            ->typeSlowly('title', 'Updated Title')
            ->typeSlowly('description', 'Updated Description')
            ->type('date', '01-01-2027')
            ->select('category', 'event')
            ->typeSlowly('price', '25')
            ->typeSlowly('capacity', '30');

            $browser->script([
                'document.getElementById("submitButton").scrollIntoView()',
                'document.getElementById("submitButton").click()'
            ]);

            $browser->waitForLocation(route('admin.events.index'))
                ->assertSee('Updated Title');
        });
    }

    public function testDeleteEvent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('admin.event.show', 1)
                ->script([
                    'document.getElementById("submitButton").scrollIntoView()'
                ]);

            $browser->press('Delete event')
                ->waitForLocation(route('admin.events.index'))
                ->assertDontSee('test2');
        });
    }

    public function testUpdateArchivedEvent()
    {
        $this->browse(function (Browser $browser) {
            $browser->visitRoute('admin.event.show', 2)
            ->pause(1000)
            ->assertSee('Update event')
            ->typeSlowly('title', 'Updated Archived Title')
            ->typeSlowly('description', 'Updated Archived Description')
            ->type('date', '01-01-2025')
            ->select('category', 'event')
            ->typeSlowly('price', '30')
            ->typeSlowly('capacity', '40')
            ->attach('gallery[]', storage_path('app/public/images/banner-2.jpg'));

            $browser->script([
                'document.getElementById("submitButton").scrollIntoView()',
                'document.getElementById("submitButton").click()'
            ]);

            $browser->waitForLocation(route('admin.events.index'))
                ->assertSee('Updated Archived Title');
        });
    }
}
