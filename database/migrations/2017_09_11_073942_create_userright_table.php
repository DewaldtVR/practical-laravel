<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserrightTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userright', function (Blueprint $table) {
            $table->increments('userrightid');
            $table->string('rightname', 255);
            $table->string('rightslug', 100);
            $table->timestamps();
        });

        DB::table('userright')->insert(["rightname" => "Setup", "rightslug" => "setup"]);
        DB::table('userright')->insert(["rightname" => "Setting Management", "rightslug" => "setting_management"]);
        DB::table('userright')->insert(["rightname" => "User Management", "rightslug" => "user_management"]);
        DB::table('userright')->insert(["rightname" => "Client Management", "rightslug" => "client_management"]);
        DB::table('userright')->insert(["rightname" => "Contact Management", "rightslug" => "contact_management"]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userright');
    }
}
