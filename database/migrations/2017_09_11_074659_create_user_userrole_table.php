<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserUserroleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_userrole', function (Blueprint $table) {
            $table->unsignedInteger('userroleid');
            $table->unsignedInteger('userid');
            $table->foreign('userroleid')
                ->references('userroleid')->on('userrole')
                ->onDelete('cascade');

            $table->foreign('userid')
                ->references('userid')->on('user')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_userrole');
    }
}
