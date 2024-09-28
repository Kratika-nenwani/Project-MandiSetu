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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mandivyapari_id');
            $table->unsignedBigInteger('dukandar_id');
            $table->unsignedBigInteger('product_id');
            $table->string('quantity');
            $table->string('unit');
            $table->string('price_per_unit');
            $table->string('total');
            $table->timestamps();

            $table->foreign('mandivyapari_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('dukandar_id')->references('id')->on('dukandars')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
