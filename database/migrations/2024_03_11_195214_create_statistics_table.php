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
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->integer('count')->default(0);
            $table->integer('sort')->default(0);
            $table->integer('status')->default(0);
            $table->boolean('is_plus')->default(0);
            $table->timestamps();
        });
        Schema::create('statistic_translations', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->foreignId('translatable_id')->constrained('statistics')->onDelete('cascade');
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
        Schema::dropIfExists('statistics');
    }
};
