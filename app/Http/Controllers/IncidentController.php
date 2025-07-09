<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Incident::with('user');

        if ($request->filled('date')) {
            $query->whereDate('date', $request->input('date'));
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->input('location') . '%');
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->filled('category')) {
            $query->where('title', 'like', '%' . $request->input('category') . '%');
        }

        $incidents = $query->paginate(10)->withQueryString();
        $users = User::all();

        return view('incidents.index', compact('incidents', 'users'));
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

    public function getIncidentsForMap()
    {
        $incidents = Incident::whereNotNull('latitude')->whereNotNull('longitude')->get();
        return response()->json($incidents);
    }

    public function getStatsByType()
    {
        // For demonstration, we'll group by the first word of the title.
        // In a real app, you'd have a dedicated 'type' or 'category' column.
        $stats = Incident::select(
                DB::raw("SUBSTRING_INDEX(title, ' ', 1) as type"),
                DB::raw('count(*) as count')
            )
            ->groupBy('type')
            ->pluck('count', 'type');

        return response()->json([
            'labels' => $stats->keys(),
            'data' => $stats->values(),
        ]);
    }

    public function getStatsByDay()
    {
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays(29);

        $stats = Incident::select(
                DB::raw('DATE(date) as incident_date'),
                DB::raw('count(*) as count')
            )
            ->whereBetween('date', [$startDate, $endDate])
            ->groupBy('incident_date')
            ->orderBy('incident_date')
            ->pluck('count', 'incident_date');

        // Fill in missing dates with 0 counts
        $dates = collect();
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $formattedDate = $date->format('Y-m-d');
            $dates->put($formattedDate, $stats->get($formattedDate, 0));
        }

        return response()->json([
            'labels' => $dates->keys(),
            'data' => $dates->values(),
        ]);
    }
}
