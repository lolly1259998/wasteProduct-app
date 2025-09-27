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
        Schema::create('recycling_processes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('waste_id')->constrained()->onDelete('cascade');
        $table->string('method');
        $table->string('status')->default('pending');
        $table->dateTime('start_date')->nullable();
        $table->dateTime('end_date')->nullable();
        $table->decimal('output_quantity', 8, 2)->nullable();
        $table->string('output_quality')->nullable();
        $table->foreignId('responsible_user_id')->nullable()->constrained('users')->onDelete('set null');
        $table->text('notes')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recycling_processes');
    }
};
