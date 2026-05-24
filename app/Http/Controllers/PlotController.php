<?php

namespace App\Http\Controllers;

use App\Models\Plot;
use Illuminate\Http\Request;

class PlotController extends Controller
{
    // Show all plots
    public function index(Request $request)
    {
        $query = Plot::query();

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $plots = $query->latest()->paginate(10);

        return view('plots.index', compact('plots'));
    }

    // Show create form
    public function create()
    {
        return view('plots.create');
    }

    // Store new plot
    public function store(Request $request)
    {
        $request->validate([
            'plot_number' => 'required|string|max:50',
            'section'     => 'required|string|max:50',
            'status'      => 'required|in:available,reserved,occupied',
            'price'       => 'required|numeric|min:0',
        ]);

        Plot::create($request->all());

        return redirect()->route('plots.index')
                         ->with('success', 'Plot created successfully.');
    }

    // Show single plot
    public function show(Plot $plot)
    {
        $plot->load(['owners', 'deceased', 'burials', 'payments']);
        return view('plots.show', compact('plot'));
    }

    // Show edit form
    public function edit(Plot $plot)
    {
        return view('plots.edit', compact('plot'));
    }

    // Update plot
    public function update(Request $request, Plot $plot)
    {
        $request->validate([
            'plot_number' => 'required|string|max:50',
            'section'     => 'required|string|max:50',
            'status'      => 'required|in:available,reserved,occupied',
            'price'       => 'required|numeric|min:0',
        ]);

        $plot->update($request->all());

        return redirect()->route('plots.index')
                         ->with('success', 'Plot updated successfully.');
    }

    // Delete plot
    public function destroy(Plot $plot)
    {
        $plot->delete();

        return redirect()->route('plots.index')
                         ->with('success', 'Plot deleted successfully.');
    }
}