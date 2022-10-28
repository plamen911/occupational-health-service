<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laboratory_indicators', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('name');
            $table->decimal('min_value', 10)->nullable()->default(0.00);
            $table->decimal('max_value', 10)->nullable()->default(0.00);
            $table->string('dimension')->nullable();
            $table->integer('position')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laboratory_indicators');
    }
};
