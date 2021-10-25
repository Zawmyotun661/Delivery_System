<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->integer('shopper_id');
            $table->date('date');
            $table->string('package_name')->nullable();
            $table->string('package_size')->nullable();
            $table->string('receiver_name');
            $table->text('phone');
            $table->longText('address');
            $table->integer('township_id');
            $table->integer('price');
            $table->integer('delivery_fee');
            $table->string('status');
            $table->string('remark')->nullable();
            $table->string('image')->nullable();
            $table->string('payment_status')->nullable();
            $table->integer('driver_id')->nullable();
         
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packages');
    }
}
