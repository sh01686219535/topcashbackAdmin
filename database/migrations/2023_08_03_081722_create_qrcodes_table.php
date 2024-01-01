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
        Schema::create('qrcodes', function (Blueprint $table) {
            $table->id();
            $table->string('qr_code')->nullable();
            $table->string('qr_code_data')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('user_email')->nullable();
            $table->string('offer_title')->nullable();
            $table->string('offer_amount')->nullable();
            $table->string('percentage_amount')->nullable();
            $table->string('purchase_amount')->nullable();
            $table->boolean('sent_email')->default(False);
            $table->unsignedBigInteger('admin_id'); // Add the foreign key column
            $table->unsignedBigInteger('approved_id')->nullable();
            $table->foreign('approved_id')->references('id')->on('merchants')->onDelete('cascade');
            $table->unsignedBigInteger('offer_id')->nullable();
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
            $table->dateTime('approved_date')->nullable();
            $table->timestamps();
         
            $table->enum('status', ['pending', 'approved', 'declined'])->default('pending');

            // Define the foreign key relationship
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qrcodes');
    }
};
