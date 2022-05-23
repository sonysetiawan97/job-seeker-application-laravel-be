<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_education', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users');
            $table->string('school_name', 50);
            $table->enum('degree', ['sd', 'smp', 'sma', 's1', 's2', 's3']);
            $table->string('field_of_study', 50);
            $table->string('location', 150);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->float('grade')->nullable();
            $table->text('description')->nullable();

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
        Schema::dropIfExists('user_education');
    }
}
