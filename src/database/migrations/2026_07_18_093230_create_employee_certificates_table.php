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
        Schema::create('employee_certificates', function (Blueprint $table) {

            $table->id();

            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();

            $table->string('title');

            $table->string('organization')->nullable();

            $table->date('issued_at')->nullable();

            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_certificates');
    }
};
