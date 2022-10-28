<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laboratory_researches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prophylactic_checkup_id')->nullable();
            $table->unsignedBigInteger('laboratory_indicator_id')->nullable();
            $table->string('type')->nullable();
            $table->string('value')->nullable();
            $table->timestamps();

            $table->foreign('prophylactic_checkup_id')
                ->references('id')
                ->on('prophylactic_checkups')
                ->onDelete('cascade');

            $table->foreign('laboratory_indicator_id')
                ->references('id')
                ->on('laboratory_indicators')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laboratory_researches');
    }
};
