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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('slug')->unique();
            $table->integer('stock')->default(1);
            $table->integer('price');
            $table->boolean('is_active')->default(true);
            $table->string('image')->nullable();
            $table->string('barcode')->nullable();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_model_id')->nullable()->constrained()->nullOnDelete();
            $table->string('imei1')->nullable();
            $table->string('imei2')->nullable();
            $table->string('color')->nullable();
            $table->string('condition')->nullable(); // new/used/refurbished
            $table->string('storage_capacity')->nullable();
            $table->string('screen_size')->nullable();
            $table->string('processor')->nullable();
            $table->string('ram')->nullable();
            $table->string('battery_capacity')->nullable();
            $table->json('additional_specs')->nullable(); // for other specifications
            $table->longtext('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
