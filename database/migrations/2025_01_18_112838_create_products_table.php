<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->json('name');
            $table->json('description');
            $table->float('price')->default(0);
            $table->string('preview_image');
            $table->json('images');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};