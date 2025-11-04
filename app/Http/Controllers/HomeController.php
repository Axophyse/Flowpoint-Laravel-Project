<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function display()
    {
        $currentMonth = Carbon::now()->format('F Y');

        $totalProducts = Product::count();
        $totalSales = Sale::sum('total_amount');
        $totalTransactions = Sale::count();
        $averageSale = Sale::avg('total_amount');

        $monthlyAverageSales = Sale::whereMonth('sale_date', now()->month)
            ->whereYear('sale_date', now()->year)
            ->avg('total_amount');

        $monthlyTotalSales = Sale::whereMonth('sale_date', now()->month)
            ->whereYear('sale_date', now()->year)
            ->sum('total_amount');

        $monthlyTotalTransaction = Sale::whereMonth('sale_date', now()->month)
            ->whereYear('sale_date', now()->year)
            ->count('total_amount');

        // Daily Sales for Current Month
        $dailySales = Sale::select(
            DB::raw("CAST(strftime('%d', sale_date) AS INTEGER) as day"),
            DB::raw("SUM(total_amount) as total")
        )
            ->whereMonth('sale_date', Carbon::now()->month)
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total', 'day');

        return view('dashboard', compact(
            'totalProducts',
            'totalSales',
            'totalTransactions',
            'averageSale',
            'dailySales',
            'monthlyTotalSales',
            'monthlyAverageSales',
            'monthlyTotalTransaction',
            'currentMonth'
        ));
    }
}
