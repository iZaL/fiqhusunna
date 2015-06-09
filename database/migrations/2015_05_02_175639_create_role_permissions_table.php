<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolePermissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        // Creates the permission_role (Many-to-Many relation) table
        Schema::create('role_permissions', function($table)
        {
            $table->increments('id');
            $table->integer('role_id')->unsigned()->index();
            $table->integer('permission_id')->unsigned()->index();
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
        Schema::drop('role_permissions');
    }

}
