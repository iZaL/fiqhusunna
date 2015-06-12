<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('albums', function (Blueprint $table) {
            //
            $table->increments('id');
            $table->integer('category_id')->index()->nullable();
            $table->string('name_ar');
            $table->string('name_en')->nullable();
            $table->string('slug')->nullable();
            $table->text('description_ar');
            $table->text('description_en')->nullable();
            $table->string('cover')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('albums', function (Blueprint $table) {
            //
            $table->drop();
        });
    }
}
