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
        Schema::create('invest_amounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('child_id');
            $table->integer('pull_detail_id');
            $table->integer('years');
            $table->integer('rate'); // Interest rate percentage
            $table->date('end_date');
            $table->decimal('amount', 8, 2); // Principal
            $table->decimal('final_amount', 8, 2); // Amount + interest
            $table->timestamps();

            $table->foreign('child_id')->references('id')->on('childe')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invest_amounts');
    }
};
