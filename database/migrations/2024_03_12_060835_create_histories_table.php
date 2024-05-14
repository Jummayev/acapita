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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->year('year');
            $table->integer('status')->default(0);
            $table->integer('sort')->default(0);
            $table->timestamps();
        });
        Schema::create('history_translations', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->foreignId('translatable_id')->constrained('histories')->onDelete('cascade');
            $table->string('locale')->index();
            $table->unique(['translatable_id', 'locale']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
