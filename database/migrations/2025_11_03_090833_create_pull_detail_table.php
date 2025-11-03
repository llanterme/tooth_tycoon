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
        Schema::create('pull_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('child_id');
            $table->integer('teeth_number');
            $table->decimal('reward', 8, 2);
            $table->string('picture')->nullable();
            $table->date('pull_date');
            $table->timestamps();

            $table->foreign('child_id')->references('id')->on('childe')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pull_detail');
    }
};
