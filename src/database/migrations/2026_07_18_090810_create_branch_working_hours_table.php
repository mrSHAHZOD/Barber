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
        Schema::create('branch_working_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->tinyInteger('week_day'); // 1=Mon ... 7=Sun

            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->boolean('is_closed')->default(false);

            $table->timestamps();

            $table->unique(['branch_id', 'week_day']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_working_hours');
    }
};
