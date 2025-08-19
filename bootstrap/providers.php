<?php

return [
App\Providers\AppServiceProvider::class,
    App\Providers\BroadcastServiceProvider::class,
    // EventServiceProvider removed to prevent duplicate listener registration
    // Laravel auto-discovery will handle event-listener mapping
];