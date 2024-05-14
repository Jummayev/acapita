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
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->default(1);
            $table->integer('sort')->default(0);
            $table->timestamps();
        });
        Schema::create('agreement_translations', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->json('items');
            $table->foreignId('translatable_id')->constrained('agreements')->onDelete('cascade');
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
        Schema::dropIfExists('agreements');
    }
};
