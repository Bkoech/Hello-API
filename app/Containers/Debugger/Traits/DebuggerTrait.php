<?php

namespace App\Containers\Debugger\Traits;

use App;
use DB;
use File;
use Illuminate\Support\Facades\Config;
use Log;


/**
 * Class DebuggerTrait.
 *
 * @author  Mahmoud Zalt <mahmoud@zalt.me>
 */
trait DebuggerTrait
{

    /**
     * Write the DB queries in the Log and Display them in the
     * terminal (in case you want to see them while executing the tests).
     *
     * @param bool|false $terminal
     */
    public function runQueryDebugger($log = true, $terminal = false)
    {
        if (Config::get('database.query_debugging')) {
            DB::listen(function ($event) use ($terminal, $log) {
                $fullQuery = vsprintf(str_replace(['%', '?'], ['%%', '%s'], $event->sql), $event->bindings);

                $text = $event->connectionName . ' (' . $event->time . '): ' . $fullQuery;

                if ($terminal) {
                    dump($text);
                }

                if ($log) {
                    Log::info($text);
                }
            });
        }
    }

    /**
     * @param $request
     * @param $response
     */
    public function runRequestDebugger($request, $response)
    {

        if (App::environment() != 'testing' && Config::get('app.debug') === true) {

            Log::debug('');
            Log::debug('');
            Log::debug('REQUEST START------------------------------------------------------');

            // Endpoint URL:
            Log::debug('URL: ' . $request->getMethod() . ' ' . $request->fullUrl());

            // Request Device IP:
            Log::debug('IP: ' . $request->ip());

            // Request Headers:
            Log::debug('App Headers: ');
            $authHead = $request->header('Authorization');
            $end = $authHead ? '...' : 'N/A';
            Log::debug('   Authorization = ' . substr($authHead, 0, 80) . $end);

            // Request Data:
            if ($request->all()) {
                $data = http_build_query($request->all(), '', ' ; ');
            } else {
                $data = 'N/A';
            }
            Log::debug('Request Data: ' . $data);

            // Authenticated User:
            if ($request->user()) {
                $user = 'ID: ' . $request->user()->id;
            } else {
                $user = 'N/A';
            }
            Log::debug('Authenticated User: ' . $user);

            // Response Content:
            if ($response && method_exists($response, 'content')) {
                Log::debug('Response: ' . substr($response->content(), 0, 700) . '...');
            }
        }
    }

}
