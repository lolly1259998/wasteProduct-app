<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->date('deadline_registration')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->integer('participants_count')->default(0);
        });
    }

    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn(['deadline_registration', 'city', 'region', 'participants_count']);
        });
    }
};
