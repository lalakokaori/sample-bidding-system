<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Items extends Migration
{
    public function up()
{

    Schema::create('Items', function(Blueprint $table)
    {
        $table->increments('ItemID');
        $table->string('ItemName', 30);
        $table->integer('SubCategoryID')->unsigned();
        $table->foreign('SubCategoryID')->references('SubCategoryID')->on('SubCategory');
    });
}

public function down()
{

    Schema::drop('Items');
    
}
}