<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wastes', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();  // Added: matches model fillable
            $table->decimal('weight', 8, 2);
            $table->string('status');
            $table->string('image_path')->nullable();  // Added: matches model fillable
            $table->text('description')->nullable();  // Made nullable to match model
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('waste_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('collection_point_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wastes');
    }
};