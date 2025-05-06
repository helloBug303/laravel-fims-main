<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameQtyToQuantityInSalesTable extends Migration
{
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            // Renaming the 'qty' column to 'quantity'
            $table->renameColumn('qty', 'quantity');
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            // Reverting the 'quantity' column back to 'qty'
            $table->renameColumn('quantity', 'qty');
        });
    }
}