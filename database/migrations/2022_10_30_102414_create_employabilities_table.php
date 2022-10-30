<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employabilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('worker_id')->nullable();
            $table->date('published_at')->nullable();
            $table->unsignedBigInteger('mkb_code_id')->nullable();
            $table->text('diagnosis')->nullable();
            $table->string('authorities')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('employability_place')->nullable();
            $table->integer('position')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('worker_id')
                ->references('id')
                ->on('workers')
                ->onDelete('cascade');

            $table->foreign('mkb_code_id')
                ->references('id')
                ->on('mkb_codes')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employabilities');
    }
};
