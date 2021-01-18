<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_estimates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedbigInteger('task_id');
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->unsignedbigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->double('min_estimate');
            $table->double('max_estimate');
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
        Schema::dropIfExists('task_estimates');
    }
}
