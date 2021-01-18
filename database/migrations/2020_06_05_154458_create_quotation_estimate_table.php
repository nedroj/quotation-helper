<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationEstimateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_estimate', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedbigInteger('quotation_task_id');
            $table->foreign('quotation_task_id')->references('id')->on('quotation_tasks');
            $table->bigInteger('min_estimate');
            $table->bigInteger('max_estimate');
            $table->unsignedbigInteger('project_quotation_id');
            $table->foreign('project_quotation_id')->references('id')->on('project_quotations');
            $table->longText('comment');
            $table->unsignedbigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments');
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
        Schema::dropIfExists('quotation_estimate');
    }
}
