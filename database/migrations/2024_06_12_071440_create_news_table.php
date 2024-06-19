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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->Integer('year')->unsigned();
            $table->tinyInteger('month')->unsigned();
            $table->tinyInteger('day')->unsigned()->nullable();
            $table->text('context');
            $table->datetimeTz('created_at');
            $table->datetimeTz('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
