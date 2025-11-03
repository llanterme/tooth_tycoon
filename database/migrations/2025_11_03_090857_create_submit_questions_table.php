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
        Schema::create('submit_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question1')->nullable();
            $table->string('question2')->nullable();
            $table->unsignedBigInteger('childe_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('childe_id')->references('id')->on('childe')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submit_questions');
    }
};
