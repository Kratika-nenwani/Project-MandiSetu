<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('daily_rates', function (Blueprint $table) {
            $table->id();
            $table->string('state');
            $table->string('district');
            $table->string('market');
            $table->string('commodity');
            $table->string('variety');
            $table->string('grade')->nullable();
            $table->date('arrival_date'); 
            $table->decimal('min_x0020_price'); 
            $table->decimal('max_x0020_price');
            $table->decimal('modal_x0020_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_rates');
    }
};
