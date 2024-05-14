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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->integer('sort')->default(0);
            $table->foreignId('file_id')->constrained('files');
            $table->integer('status')->default(0);
            $table->foreignId('page_id')->nullable()->constrained('pages');
            $table->timestamps();
        });
        Schema::create('banner_translations', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->string('link')->nullable();
            $table->foreignId('translatable_id')->constrained('banners')->onDelete('cascade');
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
        Schema::dropIfExists('banners');
    }
};
