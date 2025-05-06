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
        Schema::table('media', function (Blueprint $table) {
            // Add columns here
            if (!Schema::hasColumn('media', 'file_name')) {
                $table->string('file_name', 255);  // VARCHAR(255)
            }
            if (!Schema::hasColumn('media', 'file_type')) {
                $table->string('file_type', 100);  // VARCHAR(100)
            }
        });
    }

    public function down()
    {
        Schema::table('media', function (Blueprint $table) {
            // Drop the columns if rolling back
            $table->dropColumn(['file_name', 'file_type']);
        });
    }

};
