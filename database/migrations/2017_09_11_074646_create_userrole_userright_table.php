<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserroleUserrightTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userrole_userright', function (Blueprint $table) {
            $table->unsignedInteger('userroleid');
            $table->unsignedInteger('userrightid');
            $table->foreign('userroleid')
                ->references('userroleid')->on('userrole')
                ->onDelete('cascade');
            $table->foreign('userrightid')
                ->references('userrightid')->on('userright')
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
        Schema::dropIfExists('userrole_userright');
    }
}
