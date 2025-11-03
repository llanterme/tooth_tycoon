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
        Schema::create('cash_outs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('child_id');
            $table->unsignedBigInteger('pull_detail_id');
            $table->decimal('amount', 8, 2);
            $table->timestamps();

            $table->foreign('child_id')->references('id')->on('childe')->onDelete('cascade');
            $table->foreign('pull_detail_id')->references('id')->on('pull_detail')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_outs');
    }
};
