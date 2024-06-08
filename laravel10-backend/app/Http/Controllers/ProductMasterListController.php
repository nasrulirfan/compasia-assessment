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
        return ProductMasterList::all();
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductMasterList $productMasterList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductMasterList $productMasterList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductMasterList $productMasterList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductMasterList $productMasterList)
    {
        //
    }
}
