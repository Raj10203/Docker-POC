<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    /**
     * Quick endpoint to verify cache and mail functionality.
     * GET /debug/test-cache-mail
     */
    public function check()
    {
        // Cache test
        $key = 'docker_poc_integration_test';
        Cache::put($key, 'ok', 60);
        $cached = Cache::get($key);

        // Mail test
        $mailResult = 'not_sent';

        try {
            Mail::raw('This is a test email from Docker-POC to verify Mailpit integration.', function ($message) {
                $message->to(config('mail.from.address', 'hello@example.com'))
                        ->subject('Mailpit Test');
            });

            $mailResult = 'sent';
        } catch (\Throwable $e) {
            Log::error('TestController mail send failed: ' . $e->getMessage());
            $mailResult = 'error: ' . $e->getMessage();
        }

        return response()->json([
            'cache_key' => $key,
            'cache_value' => $cached,
            'cache_driver' => config('cache.default'),
            'mail' => $mailResult,
        ]);
    }
}
