<?php

namespace App\Http\Controllers\Stats;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Agregator\Agency;
use App\Models\Agregator\Application;
use App\Models\Agregator\Developer;
use App\Models\Agregator\User;
use Inertia\Inertia;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $viewMode = !empty($request->input('viewMode')) ? $request->input('viewMode') : 'dataTable';
        //echo '<pre>'; var_dump($viewMode); echo '</pre>'; die;
        $filter = $request->input('filter');

        // select agents with active reservations
        $agentWithReservationIdies = Application::where('is_active', 1)->get('applicant_id')->unique('applicant_id')->toArray();
        $agentWithReservationIdies = Arr::flatten($agentWithReservationIdies, 1);

        // Define the list of agencies with active reservations
        $agencyWithReservationInigueIdies = [];
        $agencyWithReservation = [];
        foreach ($agentWithReservationIdies as $agentId) {
            $agent = User::where('id', $agentId)->first();
            
            if (!empty($agent->agency) && !array_key_exists($agent->agency->id, $agencyWithReservationInigueIdies)) {
                array_push($agencyWithReservationInigueIdies, $agent->agency->id);
                $agencyWithReservation[$agent->agency->id] = $agent->agency->name;
            }
        }
        // asort($agencyWithReservation);

        // Define the list of developers with active reservations
        $developerWithReservationIdies = Application::where('is_active', 1)->get('developer_id')->unique('developer_id')->toArray();
        $developerWithReservationIdies = Arr::flatten($developerWithReservationIdies, 1);

        $developers = Developer::whereIn('id', $developerWithReservationIdies)->get(['id', 'name'])->sortBy('name')->toArray();
        
        // all actual statuses of active reservations
        $actualStatuses = Application::where('is_active', 1)->orderBy('status')->get('status')->unique('status')->toArray();
        $actualStatuses = Arr::flatten($actualStatuses, 1);
        $statuses = [];
        foreach ($actualStatuses as $status) {
            $statuses[$status] = Application::$status[$status];
        }

        $selectFields = ['application.*', 'application_history.made_at'];
        
        $query = Application::join('application_history', 'application_history.application_id', '=', 'application.id')
            ->with('agency', 'developer');
        
        // date range filter
        if (!empty($filter['dates'])) {
            $startDate = date('Y-m-d', strtotime($filter['dates'][0]));
            $endDate = date('Y-m-d', strtotime($filter['dates'][1]));
            $query->whereBetween('application_history.made_at', [$startDate, $endDate]);
        }

        // status filter
        if (!empty($filter['status'])) {
            $query->whereIn('application_history.action', $filter['status']);
        }

        // developer filter
        if (!empty($filter['developer'])) {
            $query->whereIn('application.developer_id', $filter['developer']);
        }

        // agency filter
        if (!empty($filter['agency'])) {
            $selectFields = array_merge($selectFields, ['user.email as applicant_email']);
            $query->join('user', 'user.id', '=', 'application.applicant_id');
            $query->whereIn('user.agency_id', $filter['agency']);
        }

        $query->select($selectFields);
        $query->orderBy('application.updated_at', 'desc');

        $applications = $viewMode === 'dataTable' ? $query->paginate(15) : $query->get();
        $count = $viewMode === 'dataTable' ? $applications->total() : $applications->count();
       
        /** Groupped by developer */
        // map applications
        if ($viewMode === 'byDeveloper') {
            $mapByDeveloper = $applications->map(function($appl, $key) {
                if ($appl->developer !== null) {
                    return [$appl->developer->name => $appl];
                }
            });

            // group by developer
            $applicationsByDeveloper = [];
            foreach ($mapByDeveloper->toArray() as $itemArr) {
                if ($itemArr !== null) {
                    foreach ($itemArr as $developerName => $data) {
                        $applicationsByDeveloper[$developerName][] = $data;
                    }
                }
            }
        }          

        /** Groupped by agency and Agency+Developer */
        // map applications
        if ($viewMode === 'byAgency' || $viewMode === 'byAgencyAndDeveloper') {
            $mapByAgency = $applications->map(function($appl, $key) {
                if ($appl->agency !== null) {
                    return [$appl->agency->name => $appl];
                }
            });
            $mapByAgencyArr = $mapByAgency->toArray();

            // group by agency
            $applicationsByAgency = [];
            foreach ($mapByAgencyArr as $itemArr) {
                if ($itemArr !== null) {
                    foreach ($itemArr as $agencyName => $data) {
                        $applicationsByAgency[$agencyName][] = $data;
                    }
                }
            }
        }

        // group by agency and then by developer
        if ($viewMode === 'byAgencyAndDeveloper') {
            $applicationsByAgencyAndDeveloper = [];
            foreach ($applicationsByAgency as $agencyName => $agencyObjects) {
                foreach ($agencyObjects as $object) {
                $applicationsByAgencyAndDeveloper[$agencyName][$object->developer->name][] = $object; 
                }
            }
        }

        return Inertia::render('Stats/Booking/Index', [
            'statuses' => $statuses,
            'agencies' => $agencyWithReservation,
            'developers' => $developers,
            'reservations' => $viewMode === 'dataTable' ? $applications : [],
            'reservationsByDeveloper' => $viewMode === 'byDeveloper' && isset($applicationsByDeveloper) ? $applicationsByDeveloper : [],
            'reservationsByAgency' => $viewMode === 'byAgency' && isset($applicationsByAgency) ? $applicationsByAgency : [],
            'reservationsByAgencyAndDeveloper' => $viewMode === 'byAgencyAndDeveloper' && isset($applicationsByAgencyAndDeveloper) ? $applicationsByAgencyAndDeveloper : [],
            'viewMode' => !empty($viewMode) ? $viewMode : 'dataTable',
            'path' => $request->url(),
            'amount' => $count,
        ]);
    }
}
