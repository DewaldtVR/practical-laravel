<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact', function (Blueprint $table) {
            $table->increments('contactid');
            $table->unsignedInteger('clientid')->nullable();
            $table->unsignedInteger('userid')->nullable();
            $table->string('name');
            $table->string('surname');
            $table->string('email');
            $table->timestamps();
            $table->foreign('clientid', 'fk_client_rp_idx')
                ->references('clientid')->on('client')
                ->onDelete('no action')
                ->onUpdate('no action');
            $table->foreign('userid', 'fk_user_rp_idx')
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
        Schema::dropIfExists('contact');
    }
}
