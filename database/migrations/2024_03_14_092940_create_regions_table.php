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
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('tax_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('region_translations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('status')->default(0);
            $table->foreignId('translatable_id')->index()->constrained("regions")->cascadeOnDelete();
            $table->string('locale')->index();
            $table->unique(['locale', 'translatable_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};
