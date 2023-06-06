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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(
                \App\Models\Product::class
            )->constrained('products');
            $table->foreignIdFor(
                \App\Models\User::class
            )->constrained('users');
            $table->boolean('has_sizes')->default(false);
            $table->string('size')->nullable();
            $table->unsignedTinyInteger('quantity')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
