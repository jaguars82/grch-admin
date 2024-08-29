<?php

namespace App\Http\Controllers\Stats;

use App\Models\Agregator\Developer;
use App\Models\Agregator\Newbuilding;
use App\Models\Agregator\Entrance;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FeedUpdateController extends Controller
{
    public function index(Request $request)
    {
        $data = array();
        //$complexes = array();

        $developers = Developer::all()->sortBy('name');

        foreach ($developers as $developer) {
            $developerItem = $developer->toArray();

            $developerItem['hasOutdatedFlats'] = false;
            
            $complexes = $developer->newbuildingComplexesWithActiveBuildings;
            //echo '<pre>'; var_dump($complexes); echo '</pre>'; die;

            foreach ($complexes as $complex) {
                $complexItem = $complex->toArray();

                $complexItem['hasOutdatedFlats'] = false;

                $complexItem['flatsOutdated'] = $complex->flatsWithOutdatedUpdates;

                if (count($complexItem['flatsOutdated'])) {

                    $developerItem['hasOutdatedFlats'] = true;
                    $complexItem['hasOutdatedFlats'] = true;

                    foreach ($complexItem['flatsOutdated'] as $flat) {
                        $flat->newbuildingName = Newbuilding::getNameById($flat->newbuilding_id);
                        $flat->entranceName = $flat->entrance_id ? Entrance::getNameById($flat->entrance_id) : '';
                    }
                }

                $developerItem['complexes'][] = $complexItem;
            }

            array_push($data, $developerItem);
        }

        return Inertia::render('Stats/FeedUpdate/Index', [
            'developers' => $data,
        ]);
    }
}
