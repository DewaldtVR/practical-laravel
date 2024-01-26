<?php

use App\Models\Userright;
use App\Models\Userrole;
use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('userrole', function (Blueprint $table) {

        });

        DB::table('userrole')->insert([
            'rolename' => 'Superuser'
        ]);

        $role = Userrole::all()->first();
        $user = User::all()->first();

        $role->rights()->sync(Userright::all()->pluck('userrightid'));
        $user->roles()->sync([$role->userroleid]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('userrole', function (Blueprint $table) {
            //
        });
    }
}
