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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->constrained('files');
            $table->integer('status')->default(0);
            $table->integer('sort')->default(0);
            $table->boolean('is_home')->default(0);
            $table->boolean('is_about')->default(0);
            $table->timestamps();
        });
        Schema::create('employee_translations', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('position');
            $table->text('content')->nullable();
            $table->foreignId('translatable_id')->constrained('employees')->onDelete('cascade');
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
        Schema::dropIfExists('employees');
    }
};
