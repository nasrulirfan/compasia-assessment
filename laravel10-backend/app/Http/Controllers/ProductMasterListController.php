<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessProduct;
use App\Models\ProductMasterList;
use Illuminate\Http\Request;

class ProductMasterListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'page' => 'sometimes|integer|min:1',
            'sort_field' => 'sometimes|string|in:product_id,type,brand,model,capacity,quantity|nullable',
            'sort_order' => 'sometimes|string|in:asc,desc|nullable',
        ]);

        $products = ProductMasterList::paginate(10);
        $total = $products->total();
        if ($validated['sort_order'] === 'desc'){
            $sortedProducts = $products->sortByDesc($validated['sort_field'] ?? 'product_id');
        } else {
            $sortedProducts = $products->sortBy($validated['sort_field'] ?? 'product_id');
        }
        
        return response()->json([
            'data' => $sortedProducts->values(),
            'total' => $total
        ]);
    }

    public function uploadFile(Request $request)
    {   
        $validated = $request->validate([
            'file' => 'required|mimes:xlsx|max:10000',
        ]);

        $file = $validated['file'];
        $fileName = $file->getClientOriginalName();
        $file->storeAs('uploads', $fileName);
        ProcessProduct::dispatch($fileName);

        return response()->json(['message' => 'File uploaded successfully.']);
    }
}
