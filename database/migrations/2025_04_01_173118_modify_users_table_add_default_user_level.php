<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('user_level')->default(1)->change(); // Set a default value (1 for example)
        });
    }
    
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('user_level')->default(null)->change(); // Revert to no default
        });
    }
    
};
