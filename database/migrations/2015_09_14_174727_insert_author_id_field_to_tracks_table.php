<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertAuthorIdFieldToTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tracks', function (Blueprint $table) {
            //
            $table->integer('author_id')->nullable();
            $table->string('place')->nullable();
            $table->timestamp('record_date')->nullable();
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
            $table->dropColumn('author_id');
            $table->dropColumn('place');
            $table->dropColumn('record_date');
        });
    }
}
