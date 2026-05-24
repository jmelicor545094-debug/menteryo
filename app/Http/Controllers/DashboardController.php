<?php

namespace App\Http\Controllers;

use App\Models\Plot;
use App\Models\Owner;
use App\Models\Deceased;
use App\Models\Burial;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPlots     = Plot::count();
        $availablePlots = Plot::where('status', 'available')->count();
        $reservedPlots  = Plot::where('status', 'reserved')->count();
        $occupiedPlots  = Plot::where('status', 'occupied')->count();

        $totalOwners    = Owner::count();
        $totalDeceased  = Deceased::count();
        $totalBurials   = Burial::count();

        $totalPayments  = Payment::count();
        $paidPayments   = Payment::where('status', 'paid')->count();
        $pendingPayments = Payment::where('status', 'pending')->count();
        $totalRevenue   = Payment::where('status', 'paid')->sum('amount');

        $recentBurials  = Burial::with(['deceased', 'plot', 'createdBy'])
                                ->latest()->take(5)->get();

        $recentPayments = Payment::with(['owner', 'plot'])
                                 ->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalPlots', 'availablePlots', 'reservedPlots', 'occupiedPlots',
            'totalOwners', 'totalDeceased', 'totalBurials',
            'totalPayments', 'paidPayments', 'pendingPayments', 'totalRevenue',
            'recentBurials', 'recentPayments'
        ));
    }
}
