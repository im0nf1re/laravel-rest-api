<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('courier_order');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('courier_order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courier_id')->constrained();
            $table->foreignId('order_id')->constrained();
            $table->timestamps();
        });
    }
};
