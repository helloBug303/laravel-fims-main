<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToSalesTable extends Migration
{
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            // Ensure product_id column is unsignedBigInteger
            $table->unsignedBigInteger('product_id')->change();  // Ensure product_id is unsigned big integer

            // Add the foreign key constraint
            $table->foreign('product_id')  // the foreign key in the 'sales' table
                  ->references('id')      // the referenced column in the 'products' table
                  ->on('products')        // the table the foreign key points to
                  ->onDelete('cascade');  // Optional: delete sales when a product is deleted
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            // Drop the foreign key if rolling back
            $table->dropForeign(['product_id']);
        });
    }
}
