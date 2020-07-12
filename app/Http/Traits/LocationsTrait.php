<?php
namespace App\Http\Traits;

use App\Location;
use App\ScheduleTiming;

trait  LocationsTrait {

    public function retrieveActiveLocationList()
    {
      $locations = Location::active()->get();

      foreach ($locations as $key => $location) {
	        $barangays = Location::find($location['id'])->communities()->get();

	        foreach ($barangays as $k => $val) {
	        	$community = ScheduleTiming::find($val['schedule_timing_id']);
	          	$barangays[$k]['schedule'] = $community;
	        }

	        $locations[$key]['barangays'] = $barangays;
      }
      
      return $locations;

    }

    
}