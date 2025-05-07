<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\DiscordAlerts\Facades\DiscordAlert;

class SendFormattedDiscordAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discord:formatted';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a formatted test alert with embeds to Discord';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Sending modern formatted Discord alert...');
        
        $currentTime = date('H:i:s');
        $currentDate = date('F j, Y');
        
        // Generate dynamic system metrics
        $cpuUsage = rand(10, 95);
        $memoryUsage = rand(20, 85);
        $diskSpace = rand(30, 90);
        $activeUsers = rand(5, 1000);
        $responseTime = rand(10, 500);
        
        // Determine status levels based on metrics
        $cpuStatus = $this->getStatusText($cpuUsage);
        $memoryStatus = $this->getStatusText($memoryUsage);
        $diskStatus = $this->getStatusText($diskSpace);
        
        DiscordAlert::withUsername('Agile System Monitor')
            ->message(
                "## **SCHEDULED SYSTEM CHECK**\n*Automated report generated at $currentTime on $currentDate*",
                [
                    [
                        'title' => 'Infrastructure Status Report',
                        'description' => "Comprehensive overview of current system performance and health metrics. This report is generated automatically by the monitoring system.",
                        'color' => '#9b59b6',
                        'author' => [
                            'name' => 'Agile DevOps Team',
                            'url' => 'https://example.com/devops'
                        ],
                        'fields' => [
                            [
                                'name' => "CPU Utilization - " . $cpuStatus,
                                'value' => "`{$cpuUsage}%` " . $this->generateProgressBar($cpuUsage),
                                'inline' => true
                            ],
                            [
                                'name' => "Memory Usage - " . $memoryStatus,
                                'value' => "`{$memoryUsage}%` " . $this->generateProgressBar($memoryUsage),
                                'inline' => true
                            ],
                            [
                                'name' => "Disk Space - " . $diskStatus,
                                'value' => "`{$diskSpace}%` " . $this->generateProgressBar($diskSpace),
                                'inline' => false
                            ],
                            [
                                'name' => 'Active Users',
                                'value' => "`$activeUsers` users currently online",
                                'inline' => true
                            ],
                            [
                                'name' => 'Response Time',
                                'value' => "`$responseTime ms` average",
                                'inline' => true
                            ],
                            [
                                'name' => 'System Uptime',
                                'value' => "`99.98%` over last 30 days",
                                'inline' => false
                            ]
                        ],
                        'footer' => [
                            'text' => 'Server ID: srv-prod-01 • Environment: Production'
                        ],
                        'timestamp' => date('c')
                    ],
                    [
                        'title' => 'Performance Trends',
                        'description' => "System performance has been stable over the past 24 hours with no significant anomalies detected.",
                        'color' => '#e74c3c',
                    ],
                    [
                        'title' => 'Recent Maintenance',
                        'description' => "**Completed Tasks:**\n• Database optimization (2 hours ago)\n• Cache pruning (4 hours ago)\n• Security patches applied (Yesterday)\n\n**Upcoming Maintenance:**\n• Scheduled backup (In 3 hours)\n• System updates (Tomorrow, 02:00 UTC)",
                        'color' => '#f1c40f',
                    ],
                    [
                        'title' => 'Quick Actions',
                        'description' => "• [View Full Dashboard](https://example.com/dashboard)\n• [System Logs](https://example.com/logs)\n• [Performance Metrics](https://example.com/metrics)\n• [Incident Reports](https://example.com/incidents)",
                        'color' => '#2ecc71',
                    ]
                ]
            );
        
        $this->info('Modern formatted Discord alert sent successfully!');
        
        return Command::SUCCESS;
    }
    
    /**
     * Get status text based on percentage
     * 
     * @param int $percentage
     * @return string
     */
    private function getStatusText(int $percentage): string
    {
        if ($percentage > 80) {
            return 'CRITICAL';
        } elseif ($percentage > 50) {
            return 'WARNING';
        }
        
        return 'NORMAL';
    }
    
    /**
     * Generate a visual progress bar for the Discord message
     * 
     * @param int $percentage
     * @return string
     */
    private function generateProgressBar(int $percentage): string
    {
        $filledBlocks = (int)round($percentage / 10);
        $emptyBlocks = 10 - $filledBlocks;
        
        $filled = '█';
        $empty = '░';
        
        return str_repeat($filled, $filledBlocks) . str_repeat($empty, $emptyBlocks);
    }
} 