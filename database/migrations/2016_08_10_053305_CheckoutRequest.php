<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CheckoutRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CheckoutRequests', function(Blueprint $table)
        {
            $table->increments('CheckoutRequestID');
            $table->string('CheckoutType');
            $table->integer('AccountID')->unsigned();
            $table->datetime('RequestDate');
            $table->datetime('DateOutbound');
            $table->decimal('ItemPrice', 10, 2);
            $table->decimal('EventFee', 10, 2);
            $table->decimal('ShippingFee', 10, 2);
            $table->string('FirstName');
            $table->string('MiddleName');
            $table->string('LastName');
            $table->string('Barangay_Street_Address')->nullable();
            $table->integer('CityID')->unsigned()->nullable();
            $table->integer('WarehouseNo')->unsigned()->nullable();
            $table->String('CellphoneNo', 15);
            $table->String('Landline', 10)->nullable();
            $table->boolean('Status')->default(0);
            $table->datetime('PaymentDate');
            $table->foreign('AccountID')->references('AccountID')->on('Account');
            $table->foreign('WarehouseNo')->references('WarehouseNo')->on('Warehouse');
            $table->foreign('CityID')->references('CityID')->on('City');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
