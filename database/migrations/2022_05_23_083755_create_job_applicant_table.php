<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobApplicantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_applicant', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_id')->constrained('jobs');
            $table->foreignId('user_id')->constrained('users');
            $table->enum('status_applicant', ['review', 'rejected', 'accepted', 'canceled_by_job_seeker'])->default('review');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_applicant');
    }
}
