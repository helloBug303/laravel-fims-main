<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SaleController extends Controller
{
    // Display all sales
   public function index(Request $request)
{
    $query = Sale::with('product');

    // Optional search by product name
    if ($request->has('search') && $request->search !== null) {
        $query->whereHas('product', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        });
    }

    // Optional filter by date
    if ($request->has('date') && $request->date !== null) {
        $query->whereDate('date', $request->date);
    }

    $sales = $query->orderBy('date', 'desc')->get();

    // 👇 This is the missing part that fixes your error
    $products = Product::orderBy('name')->get();

    // Optional: Retain the selected product if you use it
    $selectedProduct = null;
    if ($request->has('main_product_id')) {
        $selectedProduct = Product::find($request->main_product_id);
    }

    return view('sales.index', compact('sales', 'products', 'selectedProduct'));
}

    

    public function create(Request $request)
    {
        // Get only products that are not expired AND have stock
        $products = Product::whereDate('expiry_date', '>', now())
                           ->where('quantity', '>', 0)
                           ->get();
        
        // If a product ID is selected, get the product details
        $selectedProduct = null;
        if ($request->has('product_id')) {
            $selectedProduct = Product::find($request->input('product_id'));
        }
    
        return view('sales.create', compact('products', 'selectedProduct'));
    }
    
    

    // Store a new sale
    public function store(Request $request)
    {
        // Validate sale data
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id', // Make sure product exists
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'date' => 'required|date',
        ]);

        // Get the selected product
        $product = Product::findOrFail($validated['product_id']);

        // Check if the product is expired
        if ($product->expiration_date && $product->expiration_date < now()) {
            return back()->with('error', 'Cannot sell expired products.');
        }

        // Check if there is enough stock    
        if ($validated['quantity'] > $product->quantity) {
            return back()->with('error', 'Insufficient stock available.');
        }

        // Calculate the total
        $total = $validated['quantity'] * $validated['price'];

        // Create the sale record
        $sale = Sale::create([
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'price' => $validated['price'],
            'date' => $validated['date'],
        ]);

        // Reduce the stock
        $product->decrement('quantity', $validated['quantity']); // Decrease the quantity in stock

        // Redirect back with a success message
        return redirect()->route('sales.index')->with('msg', 'Sale created successfully!');
    }

    

    // Show the form to edit an existing sale
    public function edit($id)
    {
        $sale = Sale::with('product')->findOrFail($id);
        $products = Product::all(); // Get products to select from in the edit form
        return view('sales.edit', compact('sale', 'products'));
    }

    // Update the sale
    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'quantity' => 'required|integer',
        'price' => 'required|numeric',
        'date' => 'required|date',
    ]);

    $sale = Sale::findOrFail($id);

    // Calculate the total based on quantity and price
    $total = $validated['quantity'] * $validated['price'];

    $sale->quantity = $validated['quantity'];
    $sale->price = $validated['price'];
    $sale->date = $validated['date'];
    $sale->save();

    return redirect()->route('sales.index')->with('msg', 'Sale updated successfully!');
}

    // Delete a sale
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $product = Product::find($sale->product_id);

        // Return the product quantity if a sale is deleted
        $product->increment('quantity', $sale->quantity);

        $sale->delete();

        return redirect()->route('sales.index')->with('msg', 'Sale deleted successfully!');
    }

    public function monthlySales(Request $request)
    {
        $query = Sale::with('product');
    
        if ($request->filled('search')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
    
        if ($request->filled('month')) {
            $month = Carbon::parse($request->month);
            $query->whereMonth('date', $month->month)
                  ->whereYear('date', $month->year);
        }
    
        $sales = $query->orderBy('date', 'desc')->get();
    
        return view('sales.monthly_sales', compact('sales'));
    }
    

    public function dailySales()
    {
        // Get today's date
        $today = Carbon::today();

        // Get sales for today (current day)
        $sales = Sale::whereDate('date', $today)
                     ->with('product')  // assuming the 'Sale' model has a relationship with the 'Product' model
                     ->get();

        // Pass the sales data to the view
        return view('sales.daily_sales', compact('sales'));
    }
}
