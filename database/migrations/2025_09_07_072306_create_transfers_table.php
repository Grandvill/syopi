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
        Schema::create('transfers', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('from_id');
        $table->unsignedBigInteger('to_id');
        $table->string('status')->default('pending');
        $table->string('status_last')->nullable();
        $table->unsignedBigInteger('deposit_id');
        $table->unsignedBigInteger('withdraw_id');
        $table->decimal('discount', 24, 8)->default(0);
        $table->decimal('fee', 24, 8)->default(0);
        $table->json('extra')->nullable();
        $table->uuid('uuid')->unique();
        $table->timestamps();

        $table->foreign('from_id')->references('id')->on('wallets')->onDelete('cascade');
        $table->foreign('to_id')->references('id')->on('wallets')->onDelete('cascade');
        $table->foreign('deposit_id')->references('id')->on('transactions')->onDelete('cascade');
        $table->foreign('withdraw_id')->references('id')->on('transactions')->onDelete('cascade');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
