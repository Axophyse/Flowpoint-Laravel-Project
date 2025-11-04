<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::with('product')
            ->orderBy('sale_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $totalSales = Sale::sum('total_amount');
        $totalTransactions = Sale::count();
        $averageSale = Sale::avg('total_amount');

        return view('sales.index', compact('sales', 'totalSales', 'totalTransactions', 'averageSale'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where('quantity', '>', 0)->get();
        $paymentMethods = ['cash' => 'Cash', 'card' => 'Credit Card', 'transfer' => 'Bank Transfer', 'digital' => 'Digital Payment'];
        $statuses = ['completed' => 'Completed', 'pending' => 'Pending', 'cancelled' => 'Cancelled'];

        return view('sales.create', compact('products', 'paymentMethods', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity_sold' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email',
            'customer_phone' => 'nullable|string|max:20',
            'payment_method' => 'required|string',
            'status' => 'required|string',
            'sale_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            $product = Product::findOrFail($validated['product_id']);

            // Check stock availability
            if (!$product->hasSufficientStock($validated['quantity_sold'])) {
                throw new \Exception('Insufficient stock available. Only ' . $product->quantity . ' items left.');
            }

            // Calculate total amount
            $totalAmount = $validated['quantity_sold'] * $validated['unit_price'];

            // Create sale
            $sale = Sale::create([
                'sale_number' => Sale::generateSaleNumber(),
                'product_id' => $validated['product_id'],
                'quantity_sold' => $validated['quantity_sold'],
                'unit_price' => $validated['unit_price'],
                'total_amount' => $totalAmount,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'payment_method' => $validated['payment_method'],
                'status' => $validated['status'],
                'sale_date' => $validated['sale_date'],
                'notes' => $validated['notes'],
            ]);

            // Update product quantity if sale is completed
            if ($validated['status'] == 'completed') {
                $sale->updateProductQuantity();
            }
        });

        return redirect()->route('sales.index')
            ->with('success', 'Sale created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        $sale->load('product');
        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        $products = Product::all();
        $paymentMethods = ['cash' => 'Cash', 'card' => 'Credit Card', 'transfer' => 'Bank Transfer', 'digital' => 'Digital Payment'];
        $statuses = ['completed' => 'Completed', 'pending' => 'Pending', 'cancelled' => 'Cancelled', 'refunded' => 'Refunded'];

        return view('sales.edit', compact('sale', 'products', 'paymentMethods', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity_sold' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email',
            'customer_phone' => 'nullable|string|max:20',
            'payment_method' => 'required|string',
            'status' => 'required|string',
            'sale_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $sale) {
            $product = Product::findOrFail($validated['product_id']);
            $oldQuantity = $sale->quantity_sold;
            $newQuantity = $validated['quantity_sold'];

            // Calculate total amount
            $totalAmount = $validated['quantity_sold'] * $validated['unit_price'];

            // Update sale
            $sale->update([
                'product_id' => $validated['product_id'],
                'quantity_sold' => $validated['quantity_sold'],
                'unit_price' => $validated['unit_price'],
                'total_amount' => $totalAmount,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'payment_method' => $validated['payment_method'],
                'status' => $validated['status'],
                'sale_date' => $validated['sale_date'],
                'notes' => $validated['notes'],
            ]);

            // Update product quantity if status changed to/from completed
            if ($sale->status === 'completed') {
                $quantityDifference = $newQuantity - $oldQuantity;
                $product->quantity -= $quantityDifference;
                $product->save();
            }
        });

        return redirect()->route('sales.index')
            ->with('success', 'Sale updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        DB::transaction(function () use ($sale) {
            // Restore product quantity if sale was completed
            if ($sale->status === 'completed') {
                $product = $sale->product;
                $product->quantity += $sale->quantity_sold;
                $product->save();
            }
            $sale->delete();
        });

        return redirect()->route('sales.index')
            ->with('success', 'Sale deleted successfully!');
    }

    /**
     * Get sales report with charts
     */
    public function report()
    {
        // Daily sales for the last 30 days
        $dailySales = Sale::select(
            DB::raw("CAST(strftime('%d', sale_date) AS INTEGER) as day"),
            DB::raw("SUM(total_amount) as total")
        )
            ->whereRaw("strftime('%m', sale_date) = ?", [Carbon::now()->format('m')])
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total', 'day');

        // Sales by product category
        $salesByCategory = Sale::join('products', 'sales.product_id', '=', 'products.id')
            ->select(
                'products.category',
                DB::raw('SUM(sales.total_amount) as total_sales'),
                DB::raw('SUM(sales.quantity_sold) as total_quantity')
            )
            ->groupBy('products.category')
            ->get();

        // Sales by payment method
        $salesByPayment = Sale::select(
            'payment_method',
            DB::raw('SUM(total_amount) as total_sales'),
            DB::raw('COUNT(*) as transactions')
        )
            ->groupBy('payment_method')
            ->get();

        // Top selling products
        $topProducts = Sale::join('products', 'sales.product_id', '=', 'products.id')
            ->select(
                'products.name',
                DB::raw('SUM(sales.quantity_sold) as total_sold'),
                DB::raw('SUM(sales.total_amount) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        $totalRevenue = Sale::sum('total_amount');
        $totalItemsSold = Sale::sum('quantity_sold');
        $averageTransaction = Sale::avg('total_amount');

        return view('sales.report', compact(
            'dailySales',
            'salesByCategory',
            'salesByPayment',
            'topProducts',
            'totalRevenue',
            'totalItemsSold',
            'averageTransaction'
        ));
    }
}
