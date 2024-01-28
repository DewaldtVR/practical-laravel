<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client', function (Blueprint $table) {
            $table->collation = 'utf8_general_ci';
            $table->charset = 'utf8';
            $table->increments('clientid');
            $table->unsignedInteger('userid')->nullable();
            $table->string('name');
            $table->string('clientCode');
            $table->string('contact')->nullable();
            $table->integer('contacts_count')->default(0)->nullable();
            $table->timestamps();
            $table->foreign('userid', 'fk_user_client_idx')
                ->references('userid')->on('user')
                ->onDelete('no action')
                ->onUpdate('no action');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client');
    }
}
