<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();

            // Service ratings (1-5 scale)
            $table->tinyInteger('overall_satisfaction')->nullable()->checkBetween(1, 5);
            $table->tinyInteger('timeliness_delivery')->nullable()->checkBetween(1, 5);
            $table->tinyInteger('communication_coordination')->nullable()->checkBetween(1, 5);
            $table->tinyInteger('quality_final_outputs')->nullable()->checkBetween(1, 5);
            $table->tinyInteger('professionalism_team')->nullable()->checkBetween(1, 5);
            $table->tinyInteger('understanding_requirements')->nullable()->checkBetween(1, 5);

            // Recommendation score (NPS 0-10)
            $table->tinyInteger('nps_score')->nullable()->checkBetween(0, 10);

            // Service confirmations
            $table->enum('deliverables_met_expectations', ['yes', 'no'])->nullable();
            $table->enum('issues_resolved_quickly', ['yes', 'no', 'na'])->nullable();

            // Comment/Commendation
            $table->text('comment')->nullable();

            $table->timestamp('created_at');

            $table->index('project_id');

            // $table->unsignedTinyInteger('statement_1_rating')->comment('Service quality met expectations (1-5)');
            // $table->unsignedTinyInteger('statement_2_rating')->comment('Communication was clear and professional (1-5)');
            // $table->unsignedTinyInteger('statement_3_rating')->comment('Delivery time was satisfactory (1-5)');
            // $table->text('likes_text')->nullable();
            // $table->text('dislikes_text')->nullable();
            // $table->unsignedTinyInteger('overall_rating')->comment('Overall rating (1-5)');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
