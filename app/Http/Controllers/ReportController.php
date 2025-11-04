<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ReportController extends Controller
{
    public function index()
    {
        // Get all products for the table
        $products = Product::orderBy('created_date', 'desc')->get();

        // Get data for charts
        $categoryData = Product::select('category', DB::raw('COUNT(*) as count'))
            ->groupBy('category')
            ->get();

        $priceRangeData = Product::select(
            DB::raw('CASE
                WHEN price < 50 THEN "Under $50"
                WHEN price BETWEEN 50 AND 200 THEN "$50 - $200"
                WHEN price BETWEEN 201 AND 500 THEN "$201 - $500"
                ELSE "Over $500"
            END as price_range'),
            DB::raw('COUNT(*) as count')
        )->groupBy('price_range')
            ->get();

        $monthlySales = Sale::select(
            DB::raw("CAST(strftime('%m', sale_date) AS INTEGER) as month"),
            DB::raw("SUM(total_amount) as total_sales")
        )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $allMonthsData = array_fill(1, 12, 0);

        foreach ($monthlySales as $sale) {
            $allMonthsData[$sale->month] = $sale->total_sales;
        }

        $allMonthsData = array_values($allMonthsData);

        return view('reports', compact(
            'products',
            'categoryData',
            'priceRangeData',
            'allMonthsData'
        ));
    }

    public function dataTable()
    {
        $products = Product::orderBy('created_date', 'desc')->get();
        return view('data-table', compact('products'));
    }

    private function prepareMonthlySalesData($monthlySales)
    {
        $monthlyData = [];

        // Initialize all months with zero
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[$i] = 0;
        }

        // Fill in actual data
        foreach ($monthlySales as $sale) {
            $monthlyData[$sale->month] = floatval($sale->total_sales);
        }

        return array_values($monthlyData);
    }
}
