<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SchedulerController extends Controller
{
    public function run(Request $request)
    {
        $expected=config('services.scheduler.key');
        if(!$expected || $request->query('key') !== $expected){
            abort(403, 'Invalid scheduler key.');
        }

        Artisan::call('schedule:run');
        return response()->json([
            'status' => 'ok',
            'output' => Artisan::output(),
            'ran_at' => now()->toDateTimeString(),
        ]);
    }
}
