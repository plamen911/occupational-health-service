<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_specialist_prophylactic_checkup', function (Blueprint $table) {
            $table->unsignedBigInteger('medical_specialist_id');
            $table->unsignedBigInteger('prophylactic_checkup_id');
            $table->text('medical_opinion')->nullable();
            $table->integer('position')->nullable();
            $table->timestamps();

            $table->foreign('medical_specialist_id', 'specialist_id')
                ->references('id')
                ->on('medical_specialists')
                ->onDelete('cascade');

            $table->foreign('prophylactic_checkup_id', 'checkup_id')
                ->references('id')
                ->on('prophylactic_checkups')
                ->onDelete('cascade');

            $table->primary(['medical_specialist_id', 'prophylactic_checkup_id'], 'specialist_checkup');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_specialist_prophylactic_checkup');
    }
};
