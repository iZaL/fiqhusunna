<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTracksTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->morphs('trackeable');
            $table->string('title_en')->nullable();
            $table->string('title_ar');
            $table->string('slug')->nullable();
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('url')->nullable();
            $table->text('size')->nullable();
            $table->text('extension')->nullable();
            $table->bigInteger('views')->nullable(); // url or html
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
        Schema::table('tracks', function (Blueprint $table) {
            //
            $table->drop();
        });
    }

}
