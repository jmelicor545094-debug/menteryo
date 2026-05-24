<?php

namespace App\Http\Controllers;

use App\Models\Burial;
use App\Models\Deceased;
use App\Models\Plot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BurialController extends Controller
{
    public function index(Request $request)
    {
        $query = Burial::with(['deceased', 'plot']);

        if ($request->filled('search')) {
            $query->whereHas('deceased', function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%');
            });
        }

        $burials = $query->latest()->paginate(10);
        return view('burials.index', compact('burials'));
    }

    public function create()
    {
        $deceaseds = Deceased::all();
        $usedPlotIds = Burial::pluck('plot_id')->toArray();
        $plots = Plot::with('owners')
            ->whereNotIn('id', $usedPlotIds)
            ->where('status', 'available')
            ->get();
        return view('burials.create', compact('deceaseds', 'plots'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'deceased_id' => 'required|exists:deceased,id',
            'plot_id' => 'required|exists:plots,id',
            'burial_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $data['created_by'] = auth()->id();
        Burial::create($data);

        return redirect()->route('burials.index');
    }

    public function show(Burial $burial)
    {
        $burial->load(['deceased', 'plot']);
        return view('burials.show', compact('burial'));
    }

    public function edit(Burial $burial)
    {
        $deceaseds = Deceased::all();
        $usedPlotIds = Burial::where('id', '!=', $burial->id)->pluck('plot_id')->toArray();
        $plots = Plot::with('owners')
            ->where(function ($query) use ($usedPlotIds) {
                $query->whereNotIn('id', $usedPlotIds)
                      ->where('status', 'available');
            })->orWhere('id', $burial->plot_id)->get();
        return view('burials.edit', compact('burial', 'deceaseds', 'plots'));
    }

    public function update(Request $request, Burial $burial)
    {
        $data = $request->validate([
            'deceased_id' => 'required|exists:deceased,id',
            'plot_id' => 'required|exists:plots,id',
            'burial_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $data['created_by'] = auth()->id();
        $burial->update($data);

        return redirect()->route('burials.index');
    }

    public function destroy(Burial $burial)
    {
        $burial->delete();
        return redirect()->route('burials.index');
    }
}
