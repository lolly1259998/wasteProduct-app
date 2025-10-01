<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop existing foreign keys first
            try { $table->dropForeign(['waste_category_id']); } catch (\Throwable $e) {}
            try { $table->dropForeign(['recycling_process_id']); } catch (\Throwable $e) {}
        });

        // Make columns nullable using raw SQL (avoids doctrine/dbal requirement)
        DB::statement('ALTER TABLE products MODIFY waste_category_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE products MODIFY recycling_process_id BIGINT UNSIGNED NULL');

        Schema::table('products', function (Blueprint $table) {
            // Re-add FKs with set null on delete
            $table->foreign('waste_category_id')->references('id')->on('waste_categories')->nullOnDelete();
            $table->foreign('recycling_process_id')->references('id')->on('recycling_processes')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            try { $table->dropForeign(['waste_category_id']); } catch (\Throwable $e) {}
            try { $table->dropForeign(['recycling_process_id']); } catch (\Throwable $e) {}
        });

        DB::statement('ALTER TABLE products MODIFY waste_category_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE products MODIFY recycling_process_id BIGINT UNSIGNED NOT NULL');

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('waste_category_id')->references('id')->on('waste_categories')->cascadeOnDelete();
            $table->foreign('recycling_process_id')->references('id')->on('recycling_processes')->cascadeOnDelete();
        });
    }
};


