<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupIdToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id')->nullable(); // Add group_id column
            $table->foreign('group_id')->references('id')->on('user_groups'); // Define foreign key relationship
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['group_id']); // Drop foreign key constraint
            $table->dropColumn('group_id'); // Drop the group_id column
        });
    }
}



