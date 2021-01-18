<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotationTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotation_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedbigInteger('epic_id');
            $table->foreign('epic_id')->references('id')->on('quotation_epics');
            $table->unsignedbigInteger('quotation_id');
            $table->foreign('quotation_id')->references('id')->on('quotations');
            $table->string('title');
            $table->longText('description');
            $table->double('base_min_estimate');
            $table->double('base_max_estimate');
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
        Schema::dropIfExists('quotation_tasks');
    }
}
