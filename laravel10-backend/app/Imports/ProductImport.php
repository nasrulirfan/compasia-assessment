<?php

namespace App\Imports;

use App\Models\ProductMasterList;
use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        try {
            DB::beginTransaction();
            $product = ProductMasterList::find($row['product_id']);

            // If product doesn't exist, create a new one with appropriate quantity
            if (!$product) {
                $product = ProductMasterList::create([
                    'product_id' => $row['product_id'],
                    'type' => $row['types'],
                    'brand' => $row['brand'],
                    'model' => $row['model'],
                    'capacity' => $row['capacity'],
                    'quantity' => ($row['status'] === 'Sold') ? 0 : 1,
                ]);
            } else {
                // Update product quantity and save
                $product->quantity += ($row['status'] === 'Sold') ? -1 : 1;
            }

            $product->save();
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            throw new Exception('Transaction failed: ' . $e->getMessage());
        }
    }
}
