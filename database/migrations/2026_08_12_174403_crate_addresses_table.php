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
         Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->char('cep', 8);
            $table->string('street', 150);
            $table->string('number', 10);
            $table->string('neighborhood', 100);
            $table->string('city', 100);
            $table->char('state', 2);
            $table->string('complement', 100)->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
