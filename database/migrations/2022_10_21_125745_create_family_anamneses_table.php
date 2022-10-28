<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('family_anamneses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prophylactic_checkup_id')->nullable();
            $table->unsignedBigInteger('mkb_code_id')->nullable();
            $table->text('diagnosis')->nullable();
            $table->timestamps();

            $table->foreign('prophylactic_checkup_id')
                ->references('id')
                ->on('prophylactic_checkups')
                ->onDelete('cascade');

            $table->foreign('mkb_code_id')
                ->references('id')
                ->on('mkb_codes')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_anamneses');
    }
};
