<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prophylactic_checkup_place', function (Blueprint $table) {
            $table->unsignedBigInteger('checkup_place_id')->nullable();
            $table->unsignedBigInteger('prophylactic_checkup_id')->nullable();
            $table->timestamps();

            $table->foreign('checkup_place_id')
                ->references('id')
                ->on('checkup_places')
                ->onDelete('cascade');

            $table->foreign('prophylactic_checkup_id')
                ->references('id')
                ->on('prophylactic_checkups')
                ->onDelete('cascade');

            $table->primary(['checkup_place_id', 'prophylactic_checkup_id'], 'prophylactic_checkup_place_primary');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prophylactic_checkup_place');
    }
};
