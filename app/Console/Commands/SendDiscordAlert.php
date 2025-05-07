<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\DiscordAlerts\Facades\DiscordAlert;

class SendDiscordAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discord:alert {message?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test alert to Discord';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $message = $this->argument('message') ?? 'This is a test alert from the command line!';
        
        DiscordAlert::message($message);
        
        $this->info('Discord alert sent successfully!');
        
        return Command::SUCCESS;
    }
} 