<?php

use App\Models\OTP;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('delete_old_token', function () {
    $date = new DateTime;
    $date->modify('-5 minutes');
    $formatted = $date->format('Y-m-d H:i:s');
    OTP::where('updated_at', '<=', $formatted)->delete();
    $this->info('Delete old token success');
})->purpose('Delete old token');
