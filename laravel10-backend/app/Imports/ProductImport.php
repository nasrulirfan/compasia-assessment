<?php

namespace App\Imports;

use App\Models\ProductMasterList;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $product = ProductMasterList::find($row['product_id']);

        ## TODO: Edge cases what if it starts from sold?
        ## TODO: Edge cases quanitity become negative

        if ($product) {
            // Update the product quantity based on the status
            if ($row['status'] === 'Sold') {
                $product->quantity -= 1; // Deduct from quantity
            } elseif ($row['status'] === 'Buy') {
                $product->quantity += 1; // Add to quantity
            }
        } else {
            $product = ProductMasterList::create([
                'product_id' => $row['product_id'], 'type' => $row['types'], 'brand' => $row['brand'], 'model' => $row['model'], 'capacity' => $row['capacity'], 'quantity' => 1
            ]);
        }

        $product->save();
    }
}