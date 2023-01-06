<?php

namespace App\Http\Controllers;

use App\Models\Tariff;
use App\Models\Agregator\Developer;
use App\Models\Agregator\NewbuildingComplex;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TariffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function edit(Request $request)
    {
        $table = array();

        $developers = Developer::all()->sortBy('name');

        foreach ($developers as $developer) {
            $developer['complexes'] = $developer->newbuildingComplexes;
            //echo '<pre>'; var_dump($developer['complexes'] ); echo '</pre>';
            array_push($table, $developer);
        }

        return Inertia::render('Information/Tariff/Update', [
            'table' => $table
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DemoContent  $demoContent
     * @return \Illuminate\Http\Response
     */
    public function show(DemoContent $demoContent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DemoContent  $demoContent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DemoContent $demoContent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DemoContent  $demoContent
     * @return \Illuminate\Http\Response
     */
    public function destroy(DemoContent $demoContent)
    {
        //
    }
}
