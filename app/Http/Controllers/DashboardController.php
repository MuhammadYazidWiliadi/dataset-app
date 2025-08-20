<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use App\Models\Topik;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDataset = Dataset::count();
        $topiks = Topik::withCount('datasets')->get();

        return view('dashboard', compact('totalDataset', 'topiks'));
    }
}