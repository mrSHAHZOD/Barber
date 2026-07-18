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
        Schema::create('branch_special_days', function (Blueprint $table) {
            $table->id();
             $table->foreignId('branch_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->date('date');

            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->boolean('is_closed')->default(false);

            $table->string('reason')->nullable();

            $table->timestamps();

            $table->unique(['branch_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_special_days');
    }
};
