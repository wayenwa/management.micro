<?php
namespace App\Http\Traits;
use App\ScheduleTiming;

trait  ScheduleTimingsTrait {

    public function scheduleTimingList()
    {

      return ScheduleTiming::orderBy('name', 'asc')->get();

    }
}