<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_master_list', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('type');
            $table->string('brand');
            $table->string('model');
            $table->string('capacity');
            $table->unsignedInteger('quantity');  // Unsigned as quantity should not be negative
            $table->timestamps(); 

            // Adding indexes for frequently searched columns
            $table->index('type');
            $table->index('brand');
            $table->index('model');
            $table->index('capacity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_master_list');
    }
};
