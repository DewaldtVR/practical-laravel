<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'file';

    /**
     * Run the migrations.
     * @table file
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('fileid');
            $table->tinyInteger('private')->nullable()->default('0');
            $table->text('url')->nullable()->default(null);
            $table->string('originalfilename')->nullable()->default(null);
            $table->string('thumbnail')->nullable()->default(null);
            $table->string('mimetype')->nullable()->default(null);
            $table->string('filename')->nullable()->default(null);
            $table->string('size', 45)->nullable()->default(null);
            $table->softDeletes();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
