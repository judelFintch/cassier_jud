<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incidents = Incident::with('user')->get();
        return view('incidents.index', compact('incidents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('incidents.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'date' => 'required|date',
            'user_id' => 'required|exists:users,id',
        ]);

        Incident::create($request->all());

        return redirect()->route('incidents.index')
            ->with('success', 'Incident created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Incident $incident)
    {
        return view('incidents.show', compact('incident'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incident $incident)
    {
        $users = User::all();
        return view('incidents.edit', compact('incident', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Incident $incident)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'location' => 'required',
            'date' => 'required|date',
            'user_id' => 'required|exists:users,id',
        ]);

        $incident->update($request->all());

        return redirect()->route('incidents.index')
            ->with('success', 'Incident updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incident $incident)
    {
        $incident->delete();

        return redirect()->route('incidents.index')
            ->with('success', 'Incident deleted successfully');
    }
}
