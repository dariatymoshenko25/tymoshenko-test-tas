<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:delete-expired-files')->everyFiveMinutes();
