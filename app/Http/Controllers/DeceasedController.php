<?php

namespace App\Http\Controllers;

use App\Models\Deceased;
use Illuminate\Http\Request;

class DeceasedController extends Controller
{
    public function index(Request $request)
    {
        $query = Deceased::with('plot');

        if ($request->filled('search')) {
            $query->where('full_name', 'like', '%' . $request->search . '%');
        }

        $deceaseds = $query->latest()->paginate(10);
        return view('deceased.index', compact('deceaseds'));
    }

    public function create()
    {
        return view('deceased.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:150',
            'birth_date' => 'required|date',
            'death_date' => 'required|date|after_or_equal:birth_date',
        ]);

        Deceased::create($request->only(['full_name', 'birth_date', 'death_date']));
        return redirect()->route('deceased.index');
    }

    public function show(Deceased $deceased)
    {
        $deceased->load('plot');
        return view('deceased.show', compact('deceased'));
    }

    public function edit(Deceased $deceased)
    {
        return view('deceased.edit', compact('deceased'));
    }

    public function update(Request $request, Deceased $deceased)
    {
        $request->validate([
            'full_name' => 'required|string|max:150',
            'birth_date' => 'required|date',
            'death_date' => 'required|date|after_or_equal:birth_date',
        ]);

        $deceased->update($request->only(['full_name', 'birth_date', 'death_date']));
        return redirect()->route('deceased.index');
    }

    public function destroy(Deceased $deceased)
    {
        $deceased->delete();
        return redirect()->route('deceased.index');
    }
}
