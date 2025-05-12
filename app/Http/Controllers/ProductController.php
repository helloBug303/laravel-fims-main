<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Display all products
    public function index(Request $request)
    {
        $query = Product::query()->with(['category', 'media']);

        // Search & Filter Logic
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter Products Based on Stock Status
        if ($request->has('status') && $request->status == 'low') {
            $query->where('quantity', '>', 0)->where('quantity', '<=', 5);
        }
        // Filter Products Near Expiry
        if ($request->has('status') && $request->status == 'near_expiry') {
            $query->whereNotNull('expiry_date')
                ->whereDate('expiry_date', '>', now())
                ->whereDate('expiry_date', '<=', now()->addDays(7));
        }
   // Out of Stock (0 only)
   if ($request->has('status') && $request->status == 'out_of_stock') {
    $query->where('quantity', '=', 0);
}

        $products = $query->get();

        // Fetch Expired Products
        $expiredProducts = Product::whereNotNull('expiry_date')
            ->whereDate('expiry_date', '<', now())
            ->get();

        return view('products.index', compact('products', 'expiredProducts'));
    }





    // Show the form to create a new product
    public function create()
    {
        $categories = Category::all();
        $photos = Media::all();
        return view('products.create', compact('categories', 'photos'));
    }

    // Store a new product
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'expiry_date' => 'nullable|date',
            'categorie_id' => 'required|integer|exists:categories,id',
            'media_id' => 'nullable|integer|exists:media,id',
            'quantity' => 'required|integer|min:0',
            'buy_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
        ]);

        Product::create([
            'name' => $validatedData['name'],
            'expiry_date' => $validatedData['expiry_date'],
            'categorie_id' => $validatedData['categorie_id'],
            'media_id' => $validatedData['media_id'] ?? null,
            'quantity' => $validatedData['quantity'],
            'buy_price' => $validatedData['buy_price'],
            'sale_price' => $validatedData['sale_price'],
            'date' => now(),
        ]);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    // Show the form to edit a product
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $photos = Media::all();


        return view('products.edit', compact('product', 'categories', 'photos'));
    }

    // Update an existing product (full update, not just stock)
// Update product
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'buy_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'categorie_id' => 'required|integer|exists:categories,id',
            'expiry_date' => 'nullable|date',
            'media_id' => 'nullable|integer|exists:media,id',
        ]);

        $product = Product::findOrFail($id);
        $product->name = $request->input('name');
        $product->quantity = $request->input('quantity');
        $product->buy_price = $request->input('buy_price');
        $product->sale_price = $request->input('sale_price');
        $product->categorie_id = $request->input('categorie_id');
        $product->expiry_date = $request->input('expiry_date');
        $product->media_id = $request->input('media_id');
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    // Delete a product
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    // Get recent products for dashboard
    public function recentProducts()
    {
        $recent_products = Product::latest()->take(10)->get();
        return view('admin.dashboard', compact('recent_products'));
    }

    // Show low stock products
    public function showLowStock()
    {
        $lowStockProducts = Product::where('quantity', '<=', 5)->get();
        return view('admin.dashboard', compact('lowStockProducts'));
    }

    // Edit only stock
    public function editStock($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit_stock', compact('product'));
    }

    // Update only stock
    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);
        $product->quantity = $request->input('quantity');
        $product->save();

        return redirect()->route('products.index')->with('success', 'Stock updated successfully.');
    }

    // View low stock products list
    public function lowStock()
    {
        $products = Product::with('category')
            ->where('quantity', '>', 0) 
            ->where('quantity', '<=', 5) 
            ->get();
    
        $products_sold = Product::withSum('sales as totalSold', 'price')
            ->withSum('sales as totalQty', 'quantity')
            ->orderByDesc('totalQty')
            ->take(10)
            ->get();
    
        return view('products.lowstock', compact('products', 'products_sold'));
    }
    

    // Display nearly expired products (within 7 days)
    public function nearExpiry()
    {
        $thresholdDate = now()->addDays(7); // Show products expiring in next 7 days (not 30)
        $products = Product::whereNotNull('expiry_date')
            ->whereDate('expiry_date', '>', now()) // exclude already expired
            ->whereDate('expiry_date', '<=', $thresholdDate)
            ->orderBy('expiry_date')
            ->get();

        return view('products.near_expiry', compact('products'));
    }


    public function outOfStock()
    {
        $products = Product::with('category')
            ->where('quantity', '=', 0)
            ->get();

        return view('products.outofstock', compact('products'));
    }

    // ProductController.php

    public function expired()
    {
            $products = Product::whereNotNull('expiry_date')
            ->where('expiry_date', '<', now())  // Ensure the expiry_date is before today
            ->get();

    return view('products.expired', compact('products'));
    }




}
