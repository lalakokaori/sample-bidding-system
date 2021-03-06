<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ItemAuction extends Migration
{
    public function up()
{

    Schema::create('Item_Auction', function(Blueprint $table)
    {
        $table->primary(array('AuctionID','ItemID'));
        $table->integer('AuctionID')->unsigned();
        $table->integer('ItemID')->unsigned();
        $table->foreign('AuctionID')->references('AuctionID')->on('Auction');
        $table->foreign('ItemID')->references('ItemID')->on('Items');
        $table->integer('ItemPrice')->unsigned();
        $table->integer('Points')->unsigned();
        $table->integer('status')->default(1);
    });
}

public function down()
{

    Schema::drop('Item_Auction');
    
}
}
