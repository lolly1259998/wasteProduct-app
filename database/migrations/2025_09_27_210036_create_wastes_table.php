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
         Schema::create('wastes', function (Blueprint $table) {
        $table->id();
        $table->string('type');
        $table->decimal('weight', 8, 2)->nullable();
        $table->string('status');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('waste_category_id')->constrained()->onDelete('cascade');
        $table->foreignId('collection_point_id')->nullable()->constrained()->onDelete('set null');
        $table->string('image_path')->nullable();
        $table->text('description')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wastes');
    }
};
