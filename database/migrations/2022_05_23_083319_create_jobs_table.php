<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();

            $table->string('title', 50);
            $table->foreignId('company_id')->constrained('companies');
            $table->enum('work_location', ['wfo', 'wfh', 'hybrid']);
            $table->enum('work_schedule', ['full_time', 'part_time', 'freelance']);
            $table->string('work_level', 50);
            $table->enum('education_level', ['sd', 'smp', 'sma', 's1', 's2', 's3']);
            $table->text('description');
            $table->double('pay_range_start')->nullable();
            $table->double('pay_range_end')->nullable();
            $table->boolean('still_hiring')->default(true);

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
        Schema::dropIfExists('jobs');
    }
}
