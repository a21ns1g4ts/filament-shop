<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filament_shop_category_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('filament_shop_categories')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('filament_shop_products')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filament_shop_category_product');
    }
};
