<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MoveDatatypeBaseEstimatesToQEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotation_tasks', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            $table->dropColumn(['department_id', 'base_min_estimate', 'base_max_estimate']);
        });

        Schema::table('quotation_estimate', function (Blueprint $table) {
            $table->bigInteger('base_min_estimate');
            $table->bigInteger('base_max_estimate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('q_estimates', function (Blueprint $table) {
            //
        });
    }
}
