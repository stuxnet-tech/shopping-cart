<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\DataTables\ProductDataTable;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use App\Jobs\ProductImportJob;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(ProductDataTable $productDataTable)
    {
        return $productDataTable->render('product.index');
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('product.create');
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->quantity,
                'description' => $request->description,
            ]);

        foreach ($request->file('images') as $image) {
            $imagePath = $image->store('product_images', 'public');
            $product->images()->create([
                'image_path' => $imagePath,
            ]);
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Soft delete the specified product.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    /**
     * Import products from Excel or CSV.
     */
    public function upload(Request $request)
    {
        return view('product.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        $modulePath = \App\Models\Product::class;

        $data = Excel::toArray(new ProductImport, $request->file('file'));
        $csvData = $data[0] ?? [];

        if (!empty($csvData)) 
        {
            $headerData = array_shift($csvData);

            $importData = array_map(function ($row) use ($headerData) {
                return array_combine($headerData, $row);
            }, $csvData);
            
            ProductImportJob::dispatch($importData, $modulePath);

            return redirect()->route('products.index')->with('success', 'File imported and queued for processing!');
        }

        return Redirect::back()
            ->with('message', [
                'status' => 'success',
                'description' => 'No data found in the file.',
            ]);
    }

    public function forceDelete($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        
        $productImages = $product->images;
        foreach ($productImages as $image) {
            if (file_exists(public_path($image->image_path))) {
                unlink(public_path($image->image_path)); 
            }
        }
        
        $product->forceDelete();
        return redirect()->route('products.index')->with('success', 'Product permanently deleted!');
    }
}

