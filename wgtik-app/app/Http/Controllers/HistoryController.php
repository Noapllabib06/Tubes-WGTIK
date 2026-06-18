<?php

namespace App\Http\Controllers;

use App\Models\DetectionHistory;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        // Mengambil semua data riwayat dari yang terbaru
        $histories = DetectionHistory::latest()->get(); 
        
        return view('history.index', compact('histories'));
    }
}