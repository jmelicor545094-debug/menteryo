<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Plot;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index(Request $request)
    {
        $query = Owner::withCount('plots');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('contact_number', 'like', '%' . $request->search . '%');
            });
        }

        $owners = $query->latest()->paginate(10);
        return view('owners.index', compact('owners'));
    }

    public function create()
    {
        $plots = Plot::all();
        return view('owners.create', compact('plots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:150',
            'contact_number' => 'required|string|max:50',
            'address' => 'required|string',
            'plot_ids' => 'nullable|array',
            'plot_ids.*' => 'exists:plots,id',
        ]);

        $owner = Owner::create($request->only(['full_name', 'contact_number', 'address']));
        $owner->plots()->sync($request->plot_ids ?: []);

        return redirect()->route('owners.index');
    }

    public function show(Owner $owner)
    {
        $owner->load('plots');
        return view('owners.show', compact('owner'));
    }

    public function edit(Owner $owner)
    {
        $plots = Plot::all();
        $assignedPlotIds = $owner->plots()->pluck('plots.id')->toArray();
        return view('owners.edit', compact('owner', 'plots', 'assignedPlotIds'));
    }

    public function update(Request $request, Owner $owner)
    {
        $request->validate([
            'full_name' => 'required|string|max:150',
            'contact_number' => 'required|string|max:50',
            'address' => 'required|string',
            'plot_ids' => 'nullable|array',
            'plot_ids.*' => 'exists:plots,id',
        ]);

        $owner->update($request->only(['full_name', 'contact_number', 'address']));
        $owner->plots()->sync($request->plot_ids ?: []);

        return redirect()->route('owners.index');
    }

    public function destroy(Owner $owner)
    {
        $owner->plots()->detach();
        $owner->delete();

        return redirect()->route('owners.index');
    }
}
