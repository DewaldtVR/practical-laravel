<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUseruserrightTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_userright', function (Blueprint $table) {
            $table->unsignedInteger('userrightid');
            $table->unsignedInteger('userid');
            $table->foreign('userrightid')
                ->references('userrightid')->on('userright')
                ->onDelete('cascade');

            $table->foreign('userid')
                ->references('userid')->on('user')
                ->onDelete('cascade');
        });


//        DB::table('user_userright')->insert(['userid' => '2', 'userrightid' => '1']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_userright');
    }
}
