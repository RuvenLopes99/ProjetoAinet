<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductFormRequest;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;

use function Pest\Laravel\call;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) : View
    {
        $name = $request->input('name');
        $categoryId = $request->input('category_id');
        $price = $request->input('price');
        $outOfStock = $request->boolean('outOfStock');
        $belowThreshold = $request->boolean('belowThreshold'); // Use boolean for checkbox
         // Use boolean for checkbox

        $query = Product::query();

        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');

        $allowedSorts = [
            'id', 'name', 'description', 'price', 'stock', 'category_id', 'stock_lower_limit', 'stock_upper_limit'
        ];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }
        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        $query->orderBy($sort, $direction);
        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        if ($price) {
            $query->where('price', '>=', $price);
        }
        if ($belowThreshold) {
            $query->whereColumn('stock', '<', 'stock_lower_limit');
        }
        if ($outOfStock) {
            // Show products where stock is less than stock_lower_limit
            $query->where('stock', 0);
        }

        $products = $query->paginate(20);

        return view('products.index', [
            'products' => $products,
            'name' => $name,
            'categoryId' => $categoryId,
            'price' => $price,
            'outOfStock' => $outOfStock,
            'belowThreshold' => $belowThreshold,
        ]);
    }

    public function showCase(Request $request)
    {
        $query = Product::query();

        // Filter by product name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        // Filter only products with discount
        if ($request->boolean('only_discount')) {
            $query->whereNotNull('discount')
                ->where('discount', '>', 0)
                ->whereNotNull('discount_min_qty')
                ->where('discount_min_qty', '>', 0);
        }

        // Order by price
        if ($request->filled('price_order')) {
            $direction = $request->input('price_order') === 'desc' ? 'desc' : 'asc';
            $query->orderBy('price', $direction);
        }

        $products = $query->paginate(24);

        return view('products.showcase', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return the view for creating a new product
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductFormRequest $request)
    {
        // Validate and create a new product
        $newProduct = Product::create($request->validated());

        // Redirect to the products index with a success message
        $url = route('admin.products.show', ['product' => $newProduct]);
        $htmlMessage = "Product <a href='$url'><strong>{$newProduct->id}</strong>
                    - </a> New Product has been created successfully!";
        return redirect()->route('products.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // Return the view for showing a specific product
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // Return the view for editing a specific product
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductFormRequest $request, Product $product)
    {
        // Validate and update the product
        $product->update($request->validated());

        // Redirect back to the products index with a success message
        return redirect()->route('products.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete the product
        $product->delete();

        // Redirect back to the products index with a success message
        return redirect()->route('products.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', 'Product deleted successfully!');
    }
}
