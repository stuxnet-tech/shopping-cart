<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Imports\ProductImport;
use App\Jobs\ProductImportJob;
use App\DataTables\ProductDataTable;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

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

        $this->productRepository->create($request->all());

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        $product = $this->productRepository->find($id);

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

        $this->productRepository->update($id, $request->all());

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $this->productRepository->delete($id);

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

    public function forceDelete($id)
    {
        $this->productRepository->forceDelete($id);

        return redirect()->route('products.index')->with('success', 'Product permanently deleted!');
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
}

