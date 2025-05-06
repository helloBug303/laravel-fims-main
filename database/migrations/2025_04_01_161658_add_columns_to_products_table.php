<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('name', 255);       // name: VARCHAR(255)
            $table->string('quantity', 50);    // quantity: VARCHAR(50)
            $table->decimal('buy_price', 25, 2);  // buy_price: DECIMAL(25,2)
            $table->decimal('sale_price', 25, 2); // sale_price: DECIMAL(25,2)
            $table->integer('categorie_id');   // categorie_id: INT(11)
            $table->integer('media_id')->default(0); // media_id: INT(11), default 0
            $table->dateTime('date');          // date: DATETIME
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['name', 'quantity', 'buy_price', 'sale_price', 'categorie_id', 'media_id', 'date']);
        });
    }

};
