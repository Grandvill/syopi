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
        Schema::create('wallets', function (Blueprint $table) {
        $table->id();
        $table->string('holder_type');
        $table->unsignedBigInteger('holder_id');
        $table->string('name');
        $table->string('slug')->unique();
        $table->uuid('uuid')->unique();
        $table->text('description')->nullable();
        $table->json('meta')->nullable();
        $table->decimal('balance', 24, 8)->default(0);
        $table->integer('decimal_places')->default(2);
        $table->timestamps();
        $table->softDeletes();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
