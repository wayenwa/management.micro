<?php
namespace App\Http\Traits;

use App\Location;

trait  LocationsTrait {

    public function retrieveActiveLocationList()
    {
      $locations = Location::active()->get();

      foreach ($locations as $key => $location) {
          $locations[$key]['barangays'] = Location::find($location['id'])->communities()->get();
      }
      
      return $locations;

    }

    
}