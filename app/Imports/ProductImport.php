<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductImport implements ToModel
{
    public function model(array $row)
    {
        static $isHeader = true;
        
        // Skip the header row by checking the static variable
        if ($isHeader) {
            $isHeader = false;
            return null;  // Skip the first row (header)
        }

        return new Product([
            'name' => $row[0],         
            'price' => $row[1],       
            'stock' => $row[2],       
            'description' => $row[3], 
        ]);
    }
}

