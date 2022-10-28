<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_charts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('firm_id')->nullable();
            $table->unsignedBigInteger('worker_id')->nullable();
            $table->string('reg_num')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('days_off')->nullable()->default(0);
            $table->unsignedBigInteger('mkb_code_id')->nullable();
            $table->unsignedBigInteger('patient_chart_reason_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->foreign('firm_id')
                ->references('id')
                ->on('firms')
                ->onDelete('cascade');

            $table->foreign('worker_id')
                ->references('id')
                ->on('workers')
                ->onDelete('cascade');

            $table->foreign('patient_chart_reason_id')
                ->references('id')
                ->on('patient_chart_reasons')
                ->nullOnDelete();

            $table->foreign('mkb_code_id')
                ->references('id')
                ->on('mkb_codes')
                ->nullOnDelete();

            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();

            $table->foreign('deleted_by')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_charts');
    }
};
