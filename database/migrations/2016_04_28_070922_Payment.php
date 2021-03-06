<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Payment extends Migration
{
    public function up()
{
Schema::create('Payment', function(Blueprint $table)
    {
        $table->increments('PaymentID');
        $table->decimal('TotalPrice', 8, 2);
        $table->string('DeliveryAddress_Street_Brgy',50);
        $table->dateTime('PaymentDate');
        $table->integer('CityID')->unsigned();
        $table->foreign('CityID')->references('CityID')->on('City');
        $table->integer('AccountID')->unsigned();
        $table->integer('ClaimTypeID')->unsigned();
        $table->foreign('AccountID')->references('AccountID')->on('Account');
        $table->foreign('ClaimTypeID')->references('ClaimTypeID')->on('ClaimType');
    });
}

public function down()
{

    Schema::drop('Payment');
    
}
}
