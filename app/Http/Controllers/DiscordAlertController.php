<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\DiscordAlerts\Facades\DiscordAlert;

class DiscordAlertController extends Controller
{
    /**
     * Send a simple Discord alert
     */
    public function sendSimpleAlert()
    {
        DiscordAlert::message("This is a simple test alert from Laravel Discord Alerts package!");
        
        return response()->json(['message' => 'Alert sent successfully']);
    }
    
    /**
     * Send a formatted Discord alert with rich content
     */
    public function sendFormattedAlert()
    {
        DiscordAlert::withUsername('Agile Notification System')
            ->message(
                "# **SYSTEM NOTIFICATION**\n*A new event has been triggered in the application*",
                [
                    [
                        'title' => 'System Status Report',
                        'description' => "The system has detected important activity that requires attention.\n\n**Details are provided below:**",
                        'color' => '#3498db',
                        'author' => [
                            'name' => 'Agile Team',
                            'url' => 'https://example.com'
                        ],
                        'fields' => [
                            [
                                'name' => 'Service Status',
                                'value' => 'All systems operational',
                                'inline' => true
                            ],
                            [
                                'name' => 'Performance',
                                'value' => '98.7% optimal',
                                'inline' => true
                            ],
                            [
                                'name' => 'Last Updated',
                                'value' => date('Y-m-d H:i:s'),
                                'inline' => true
                            ],
                            [
                                'name' => 'Recent Activity',
                                'value' => "• User registration spike\n• Database optimization complete\n• Cache refreshed",
                                'inline' => false
                            ],
                            [
                                'name' => 'Monitoring',
                                'value' => 'Active - No alerts triggered',
                                'inline' => true
                            ],
                            [
                                'name' => 'Security',
                                'value' => 'No threats detected',
                                'inline' => true
                            ]
                        ],
                        'footer' => [
                            'text' => 'Agile System Monitor • Automated Alert'
                        ],
                        'timestamp' => date('c')
                    ],
                    [
                        'title' => 'Quick Links',
                        'description' => "Access these resources for more information:",
                        'color' => '#2ecc71',
                        'fields' => [
                            [
                                'name' => 'Dashboard',
                                'value' => '[View Dashboard](https://example.com/dashboard)',
                                'inline' => true
                            ],
                            [
                                'name' => 'Analytics',
                                'value' => '[View Analytics](https://example.com/analytics)',
                                'inline' => true
                            ],
                            [
                                'name' => 'Documentation',
                                'value' => '[View Docs](https://example.com/docs)',
                                'inline' => true
                            ]
                        ]
                    ]
                ]
            );
        
        return response()->json(['message' => 'Formatted alert sent successfully']);
    }
    
    /**
     * Send a custom Discord alert with username and avatar
     */
    public function sendCustomAlert(Request $request)
    {
        DiscordAlert::withUsername('Alert Bot')
            ->enableTTS(false)
            ->message("A custom alert with the message: " . $request->input('message', 'No message provided'));
        
        return response()->json(['message' => 'Custom alert sent successfully']);
    }
} 