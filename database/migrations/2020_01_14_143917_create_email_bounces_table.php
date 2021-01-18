<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailBouncesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_bounces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type', 255);
            $table->string('name', 255);
            $table->string('tag', 255);
            $table->string('message_id', 255);
            $table->integer('server_id');
            $table->text('description');
            $table->text('details');
            $table->string('address_to', 255);
            $table->string('address_from', 255);
            $table->string('subject', 255);
            $table->dateTime('bounced_at');
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
        Schema::dropIfExists('email_bounces');
    }
}
