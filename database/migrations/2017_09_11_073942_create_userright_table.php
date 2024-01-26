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
        DB::table('userright')->insert(["rightname" => "KycFile Management", "rightslug" => "kyctype_management"]);
        DB::table('userright')->insert(["rightname" => "Applcation Type Management", "rightslug" => "applicationtype_management"]);
        DB::table('userright')->insert(["rightname" => "Client Management", "rightslug" => "client_management"]);
        DB::table('userright')->insert(["rightname" => "Client Verification Management", "rightslug" => "client_verify_management"]);
        DB::table('userright')->insert(["rightname" => "Related Party Verification Management", "rightslug" => "relatedparty_verify_management"]);
        DB::table('userright')->insert(["rightname" => "KYC File Verification Management", "rightslug" => "kycfile_verify_management"]);
        DB::table('userright')->insert(["rightname" => "Application Verification Management", "rightslug" => "application_verify_management"]);
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
