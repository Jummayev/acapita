<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('review_uzb', function (Blueprint $table) {
            $table->id();
            $table->integer("status")->default(0);
            $table->integer("sort")->default(0);
            $table->foreignId("file_id")->nullable()->constrained("files");

            $table->timestamps();
        });
        Schema::create('review_uzb_translations', function (Blueprint $table) {
            $table->id();
            $table->text("title")->nullable();
            $table->text("description")->nullable();
            $table->text("content")->nullable();
            $table->foreignId('translatable_id')->constrained('review_uzb')->onDelete('cascade');
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
        Schema::dropIfExists('review_uzbs');
    }
};
