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
        Schema::create('filament_shop_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->nullable()->constrained('filament_shop_brands')->nullOnDelete();
            $table->json('meta')->nullable();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('quantity')->default(0);
            $table->unsignedBigInteger('security_stock')->default(0);
            $table->boolean('pinned')->default(false);
            $table->boolean('visible')->default(false);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->enum('type', ['deliverable', 'downloadable'])->nullable();
            $table->boolean('requires_shipping')->default(false);
            $table->date('published_at')->nullable();
            $table->decimal('weight_value', 10, 2)->nullable()
                ->default(0.00)
                ->unsigned();
            $table->string('weight_unit')->default('kg');
            $table->decimal('height_value', 10, 2)->nullable()
                ->default(0.00)
                ->unsigned();
            $table->string('height_unit')->default('cm');
            $table->decimal('width_value', 10, 2)->nullable()
                ->default(0.00)
                ->unsigned();
            $table->string('width_unit')->default('cm');
            $table->decimal('depth_value', 10, 2)->nullable()
                ->default(0.00)
                ->unsigned();
            $table->string('depth_unit')->default('cm');
            $table->decimal('volume_value', 10, 2)->nullable()
                ->default(0.00)
                ->unsigned();
            $table->string('volume_unit')->default('l');
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
        Schema::dropIfExists('filament_shop_products');
    }
};
