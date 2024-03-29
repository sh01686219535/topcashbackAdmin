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
            $table->string('phone');
            $table->string('token');
            $table->string('balance')->default(0.0);
            $table->string('email')->unique();
            $table->longText('security_question')->nullable();
            $table->longText('security_answer')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('confirm_password');
            $table->text('address')->nullable();
            $table->text('payment_information')->nullable();
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
