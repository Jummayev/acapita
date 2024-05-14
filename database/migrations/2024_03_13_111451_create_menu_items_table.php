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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->nullable();
            $table->string('alias')->nullable();
            $table->integer('sort')->default(0);
            $table->integer('status')->default(0);
            $table->foreignId('menu_id')->constrained('menus');
            $table->foreignId('menu_item_parent_id')->nullable()->constrained('menu_items');
            $table->timestamps();
        });

        Schema::create('menu_item_translations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('translatable_id')->constrained('menu_items')->onDelete('cascade');
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
        Schema::dropIfExists('menu_items');
    }
};
