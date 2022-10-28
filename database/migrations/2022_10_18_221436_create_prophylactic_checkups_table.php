<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prophylactic_checkups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('firm_id')->nullable();
            $table->unsignedBigInteger('worker_id')->nullable();
            $table->string('checkup_num')->nullable();
            $table->date('checkup_date')->nullable();
            $table->decimal('worker_height', 10)->nullable();
            $table->decimal('worker_weight', 10)->nullable();
            $table->integer('rr_systolic')->nullable();
            $table->integer('rr_diastolic')->nullable();
            $table->tinyInteger('is_smoking')->nullable();
            $table->tinyInteger('is_drinking')->nullable();
            $table->tinyInteger('has_bad_nutrition')->nullable();
            $table->tinyInteger('in_on_diet')->nullable();
            $table->tinyInteger('has_home_stress')->nullable();
            $table->tinyInteger('has_work_stress')->nullable();
            $table->tinyInteger('has_social_stress')->nullable();
            $table->tinyInteger('has_long_screen_time')->nullable();
            $table->decimal('sport_hours', 10)->nullable();
            $table->tinyInteger('has_low_activity')->nullable();
            $table->decimal('left_eye', 10, 1)->nullable();
            $table->decimal('left_eye2', 10, 1)->nullable();
            $table->decimal('right_eye', 10, 1)->nullable();
            $table->decimal('right_eye2', 10, 1)->nullable();
            $table->decimal('breath_vk', 10, 1)->nullable();
            $table->decimal('breath_feo', 10, 1)->nullable();
            $table->decimal('breath_tifno', 10, 1)->nullable();
            $table->unsignedBigInteger('hearing_loss_id')->nullable();
            $table->decimal('left_ear', 10, 1)->nullable();
            $table->decimal('right_ear', 10, 1)->nullable();
            $table->text('tone_audiometry')->nullable();
            $table->text('electrocardiogram')->nullable();
            $table->text('x_ray')->nullable();
            $table->text('echo_ray')->nullable();
            $table->text('family_medical_history')->nullable();
            $table->text('medical_history')->nullable();
            $table->unsignedBigInteger('ohs_conclusion_id')->nullable();  // occupational health service
            $table->text('ohs_conditions')->nullable();
            $table->date('ohs_date')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->foreign('firm_id')->references('id')->on('firms')->onDelete('cascade');
            $table->foreign('worker_id')->references('id')->on('workers')->onDelete('cascade');
            $table->foreign('hearing_loss_id')->references('id')->on('hearing_losses')->nullOnDelete();
            $table->foreign('ohs_conclusion_id')->references('id')->on('ohs_conclusions')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('deleted_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prophylactic_checkups');
    }
};
