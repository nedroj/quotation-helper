<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('issuelist_id');
            $table->foreign('issuelist_id')->references('id')->on('issuelists');
            $table->string('default_project')->nullable();
            $table->string('default_reporter')->nullable();
            $table->string('default_assignee')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->bigInteger('original_estimate')->nullable();
            $table->bigInteger('sortorder');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issues');
    }
}
