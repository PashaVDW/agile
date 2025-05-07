<?php

return [
    /*
     * The webhook URLs that we'll use to send a message to Discord.
     */
    'webhook_urls' => [
        'default' => env('DISCORD_ALERT_WEBHOOK', 'https://discord.com/api/webhooks/1369677136994111628/t1atnHyHXYmTgcwwpklGhd0MsG3ANkibarbFUjqnD9fTBHvjNiraZ-0OFXrtiIaKKAr-'),
    ],

    /*
     * Default avatar is an empty string '' which means it will not be included in the payload.
     * You can add multiple custom avatars and then specify directly with withAvatar()
     */
    'avatar_urls' => [
        'default' => '',
    ],

    /*
     * This job will send the message to Discord. You can extend this
     * job to set timeouts, retries, etc...
     */
    'job' => Spatie\DiscordAlerts\Jobs\SendToDiscordChannelJob::class,

    /*
     * It is possible to specify the queue connection that should be used to send the alert.
     */
    'queue_connection' => 'sync',
]; 