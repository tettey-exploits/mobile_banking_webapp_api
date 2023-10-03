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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string("first_name")->nullable(false)->index();
            $table->string("last_name")->nullable(false)->index();
            $table->date("date_of_birth")->nullable(false);
            $table->unsignedBigInteger("contact")->nullable(false)->unique();
            $table->unsignedBigInteger("account_number")->nullable(false)->unique();
            $table->string("location")->nullable(false);
            $table->string("username")->unique();
            $table->string("email")->unique()->nullable();
            $table->string("password")->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
