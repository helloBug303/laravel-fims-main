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
        Schema::table('sales', function (Blueprint $table) {
            if (!Schema::hasColumn('sales', 'product_id')) {
                $table->integer('product_id');     // product_id: INT(11)
            }
            if (!Schema::hasColumn('sales', 'qty')) {
                $table->integer('qty');             // qty: INT(11)
            }
            if (!Schema::hasColumn('sales', 'price')) {
                $table->decimal('price', 25, 2);    // price: DECIMAL(25,2)
            }
            if (!Schema::hasColumn('sales', 'date')) {
                $table->date('date');                // date: DATE
            }
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['product_id', 'qty', 'price', 'date']);
        });
    }

};
