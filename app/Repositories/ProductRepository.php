<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductRepository
{
    public function getAll()
    {
        return Product::all();
    }

    public function find($id)
    {
        return Product::findOrFail($id);
    }

    public function create(array $data)
    {
        $product = Product::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'stock' => $data['quantity'],
            'description' => $data['description'],
        ]);

        if (isset($data['images'])) {
            foreach ($data['images'] as $image) {
                $imagePath = $image->store('product_images', 'public');
                $product->images()->create(['image_path' => $imagePath]);
            }
        }

        return $product;
    }

    public function update($id, array $data)
    {
        $product = $this->find($id);

        $product->update([
            'name' => $data['name'],
            'price' => $data['price'],
            'stock' => $data['quantity'],
            'description' => $data['description'],
        ]);

        return $product;
    }

    public function delete($id)
    {
        $product = $this->find($id);
        $product->delete();

        return $product;
    }

    public function forceDelete($id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        foreach ($product->images as $image) {
            if (file_exists(public_path($image->image_path))) {
                unlink(public_path($image->image_path));
            }
        }

        $product->forceDelete();

        return $product;
    }

    public function importProducts(array $csvData, $modulePath)
    {
        foreach ($csvData as $row) {
            Product::create([
                'name' => $row['name'],
                'price' => $row['price'],
                'stock' => $row['quantity'],
                'description' => $row['description'] ?? null,
            ]);
        }
    }
}
