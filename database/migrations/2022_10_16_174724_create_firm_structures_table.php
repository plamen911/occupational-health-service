<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('firm_structures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('firm_id')->nullable();
            $table->unsignedBigInteger('firm_sub_division_id')->nullable();
            $table->unsignedBigInteger('firm_work_place_id')->nullable();
            $table->unsignedBigInteger('firm_position_id')->nullable();
            $table->timestamps();

            $table->foreign('firm_id')->references('id')->on('firms')->onDelete('cascade');
            $table->foreign('firm_sub_division_id')->references('id')->on('firm_sub_divisions')->onDelete('cascade');
            $table->foreign('firm_work_place_id')->references('id')->on('firm_work_places')->onDelete('cascade');
            $table->foreign('firm_position_id')->references('id')->on('firm_positions')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('firm_structures');
    }
};
