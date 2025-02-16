<?php

namespace App\Http\Controllers;

use App\Models\Agregator\Developer;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DeveloperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $developers = Developer::orderBy('name', 'asc')->get();

        return Inertia::render('Developer/Index', [
            'developers' => $developers,
        ]);
    }

    /**
     * Display the developer create form
     */
    public function create()
    {
        return Inertia::render('Developer/Create');
    }

    /**
     * Cdeate a new developer.
     */
    public function store(Request $request)
    {
        $developer = new Developer;

        $validatedData = $request->validate(Developer::validationRules());
        
        $developer->fill($validatedData);

        $developer->detail = $validatedData['detail'] ?? '';
        
        if ($request->hasFile('logofile')) {
            $fileName = FileService::storeFile($request->file('logofile')[0]);
            $developer->logo = $fileName;
        }

        $developer->save();

        return redirect()->route('developer-index');
    }

    /**
     * Display the developer edit form
     */
    public function edit(Request $request, $id)
    {
        $developer = Developer::find($id);

        return Inertia::render('Developer/Update', [
            'developer' => $developer,
        ]);
    }

    /**
     * Update an existing developer.
     */
    public function update(Request $request)
    {
        $developer = Developer::find($request->input('id'));

        $validatedData = $request->validate(Developer::validationRules());
            
        $developer->fill($validatedData);

        $developer->detail = $validatedData['detail'] ?? '';

        if ($request->hasFile('logofile')) {
            // deleting previous logo
            if ($developer->logo) {
                FileService::deleteFile($developer->logo);
                $ceveloper->logo = '';
            }

            $fileName = FileService::storeFile($request->file('logofile')[0]);
            $developer->logo = $fileName;
        }

        $developer->save();

        return redirect()->route('developer-index');
    }

    /**
     * Delete a developer
     */
    public function delete(Request $request, $id)
    {
        $developer = Developer::find($id);
        //dd($developer);
        if ($developer->hasNewbuildingComplexes()) {
            return [
                'success' => false,
                'message' => "У застройщика есть жилые комплексы",
                'status' => 500,
            ];
        }
    }

    /** 
     * Delete developer's logo
     * and return json response 
     */
    public function deleteLogo(Request $request, $id)
    {
        $developer = Developer::find($id);
        
        $result = FileService::deleteFile($developer->logo);

        if ($result['success']) {
            $developer->logo = null;
            $developer->save();
        }

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
        ], $result['status']);
    }
}
