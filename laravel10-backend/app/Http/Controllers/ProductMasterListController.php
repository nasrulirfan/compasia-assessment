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
    public function index()
    {
        return ProductMasterList::paginate(10);
    }

    public function uploadFile(Request $request)
    {   
        $validated = $request->validate([
            'file' => 'required|mimes:xlsx|max:2048',
        ]);

        $file = $validated['file'];
        $fileName = $file->getClientOriginalName();
        $file->storeAs('uploads', $fileName); // Store the file in the 'uploads' directory
        ProcessProduct::dispatch($fileName);

        return response()->json(['message' => 'File uploaded successfully.']);
    }
}
