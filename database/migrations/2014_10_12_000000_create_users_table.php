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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('mandi_license')->nullable();
            $table->string('gumasta')->nullable();
            $table->string('gst_registration')->nullable();
            $table->string('aadhar');   
            $table->string('pan');  
            $table->string('aadhar_card');   
            $table->string('pan_card');  
            $table->string('account_no');      
            $table->string('ifsc_code');          
            $table->string('statement');   
            $table->string('business_name');   
            $table->string('office_address');   
            $table->string('office_phn');
            $table->string('image');   
            $table->enum('role',['Wholesaler','MandiVyapari','SuperAdmin']);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
