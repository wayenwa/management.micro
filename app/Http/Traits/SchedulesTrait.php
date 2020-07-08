<?php
namespace App\Http\Traits;

use App\ScheduleTiming;

trait  SchedulesTrait {

    public function retrieveActiveList()
    {
      $locations = ScheduleTiming::active()->get();

      foreach ($locations as $key => $location) {
          $locations[$key]['barangays'] = Location::find($location['id'])->communities()->get();
      }
      
      return $locations;

    }

    
}