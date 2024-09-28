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
        Schema::create('dukandars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mandivyapari_id');
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('shop_name');
            $table->string('address');   
            $table->string('email')->unique()->nullable();
            $table->string('mandi_license')->nullable();
            $table->string('gumasta')->nullable();
            $table->string('gst_registration')->nullable();
            $table->string('mandi_license_no')->nullable();
            $table->string('gumasta_no')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('aadhar')->nullable();   
            $table->string('pan')->nullable();  
            $table->string('aadhar_card')->nullable();   
            $table->string('pan_card')->nullable();  
            $table->string('account_no')->nullable();      
            $table->string('ifsc_code')->nullable();          
            $table->string('statement')->nullable();   
            $table->string('office_phn')->nullable();
            $table->string('image')->nullable();  
            $table->timestamps();


            $table->foreign('mandivyapari_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dukandars');
    }
};
