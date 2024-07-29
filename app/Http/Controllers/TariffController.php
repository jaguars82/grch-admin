<?php

namespace App\Http\Controllers;

use App\Models\Agregator\Tariff;
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
        $complexes = array();

        $developers = Developer::all()->sortBy('name');

        foreach ($developers as $developer) {
            $developer['complexes'] = $developer->newbuildingComplexes;
            array_push($table, $developer);
            foreach ($developer->newbuildingComplexes as $complex) {
                array_push($complexes, $complex);
            }
        }

        $dbTable = Tariff::latest()->first();

        return Inertia::render('Information/Tariff/Update', [
            'table' => $table,
            'complexes' => $complexes,
            'dbTable' => $dbTable
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function update(Request $request)
    {
        if ($request->input('createNewTable') === true) {
            $tariff = new Tariff;
        } else {
            $tariff = Tariff::latest()->first();
        }

        $tariff->tariff_table = json_encode($request->input('complexes'));
        $tariff->developers_in_statistics = json_encode($request->input('developers_in_statistics'));
        $tariff->changes = $request->input('changes');
        $tariff->save();

        return redirect()->route('tariff-edit');
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
