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
        Schema::create('saving_goals', function (Blueprint $table) {
            $table->id()->from(1001);
            $table->unsignedBigInteger('user_id');

            $table->string('title');
            $table->text('deskription')->nullable();
            $table->decimal('total_amount', 12,2);
            $table->decimal('current_amount', 12,2)->default(0);

            $table->date('deadline')->nullable();
            $table->enum('status', ['pending', 'achieved'])->default('pending');
            $table->timestamps();

            $table->string('image')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saving_goals');
    }
};
