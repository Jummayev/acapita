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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('logo_id')->nullable()->constrained('files');
            $table->foreignId('file_id')->constrained('files');
            $table->boolean('is_home')->default(false);
            $table->integer('status')->default(0);
            $table->integer('sort')->default(0);
            $table->timestamps();
        });

        Schema::create('partner_translations', function (Blueprint $table) {
            $table->id();
            $table->text('content')->nullable();
            $table->foreignId('translatable_id')->constrained('partners')->onDelete('cascade');
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
        Schema::dropIfExists('partners');
    }
};
