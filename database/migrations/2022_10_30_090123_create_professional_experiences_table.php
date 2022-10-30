<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('professional_experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('worker_id')->nullable();
            $table->string('firm_name')->nullable();
            $table->string('job_position')->nullable();
            $table->integer('years_length')->nullable();
            $table->integer('months_length')->nullable();
            $table->integer('position')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('worker_id')
                ->references('id')
                ->on('workers')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('professional_experiences');
    }
};
