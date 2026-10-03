<?php

// Read-only application smoke checks before activating a prepared VPS release.
require dirname(__DIR__) . '/vendor/autoload.php';
$app = require dirname(__DIR__) . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

if (config('database.connections.' . config('database.default') . '.database') !== 'nironex') {
    fwrite(STDERR, "Expected the NiroNex production database.\n");
    exit(1);
}

// Keep synthetic requests from creating production sessions or cache entries.
config(['session.driver' => 'array', 'cache.default' => 'array']);
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
foreach (['/up', '/', '/login', '/register'] as $path) {
    $request = Illuminate\Http\Request::create('https://nironex.com' . $path, 'GET');
    $response = $kernel->handle($request);
    $status = $response->getStatusCode();
    $kernel->terminate($request, $response);
    echo "Prepared release $path: HTTP $status\n";
    if ($status !== 200) {
        exit(1);
    }
}
