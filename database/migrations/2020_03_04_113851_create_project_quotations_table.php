<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_quotations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedbigInteger('project_id');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->unsignedbigInteger('quotation_id');
            $table->foreign('quotation_id')->references('id')->on('quotations');
            $table->string('round');
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
        Schema::dropIfExists('project_quotations');
    }
}
