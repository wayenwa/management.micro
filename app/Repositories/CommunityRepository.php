<?php

namespace App\Repositories;

use App\Location;
use App\Community;
use App\ScheduleTiming;

class CommunityRepository
{
    /**
     * @var Location
     */
    protected $location;

    /**
     * MerchantRepository constructor.
     * 
     * @param Location $location
     * @param Community $community
     * @param ScheduleTiming $scheduleTiming
     */

     public function __construct(Location $location, Community $community, ScheduleTiming $scheduleTiming)
     {
        $this->location = $location;
        $this->community = $community;
        $this->scheduleTiming = $scheduleTiming;
     }
     /**
      * @param $data
      * @return Location
      */
    public function retrieveActiveLocationList()
    {
        $model = new $this->location;
        $locations = $model->active()->get();

        foreach ($locations as $key => $location) {
                $barangays = $model->find($location['id'])->communities()->get();

                foreach ($barangays as $k => $val) {
                    $community = $this->scheduleTiming->find($val['schedule_timing_id']);
                    $barangays[$k]['schedule'] = $community;
                }

                $locations[$key]['barangays'] = $barangays;
        }
        
        return $locations;
    }

    public function save($data)
    {
        $model = new $this->community;

        $model->create($data);

        return $model->fresh();
    }

    public function update($id, $data)
    {
        $model = new $this->community;

        $model->where('id', $id)->update($data);

        return $model->fresh();
    }

    public function getById($id)
    {
        $model = new $this->community;

        $model->find($id);

        return $model;
    }



}