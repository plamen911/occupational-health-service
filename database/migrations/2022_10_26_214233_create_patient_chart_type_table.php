<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_chart_type', function (Blueprint $table) {
            $table->unsignedBigInteger('patient_chart_id');
            $table->unsignedBigInteger('patient_chart_type_id');
            $table->timestamps();

            $table->foreign('patient_chart_id')
                ->references('id')
                ->on('patient_charts')
                ->onDelete('cascade');

            $table->foreign('patient_chart_type_id')
                ->references('id')
                ->on('patient_chart_types')
                ->onDelete('cascade');

            $table->primary(['patient_chart_id', 'patient_chart_type_id'], 'chart_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_chart_type');
    }
};
