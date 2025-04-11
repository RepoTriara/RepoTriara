<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;




\Illuminate\Support\Facades\Schedule::command('clean:expired-files')->everyMinute();
\Illuminate\Support\Facades\Schedule::command('files:clear-part-files')->everyMinute();




