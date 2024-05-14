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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable()->unique();
            $table->string('alias')->nullable();
            $table->integer('sort')->default(0);
            $table->integer('type')->nullable();
            $table->integer('status')->default(0);
            $table->foreignId('page_id')->nullable()->constrained('pages');
            $table->timestamps();
        });

        Schema::create('menu_translations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('translatable_id')->constrained('menus')->onDelete('cascade');
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
        Schema::dropIfExists('menus');
    }
};
